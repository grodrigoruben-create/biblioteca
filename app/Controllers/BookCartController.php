<?php
namespace App\Controllers;
use App\Models\BookModel;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
class BookCartController extends BaseController
{
    private $session;
    private $bookModel;

    public function __construct()
    {
        $this->session = session();
        $this->bookModel = new BookModel();
    }
    /**
     * Muestra el catálogo de libros con paginación
     */
    public function index()
    {
        $perPage = 6; 
        $data = [
            'libros' => $this->bookModel->paginateConAutores($perPage),
            'pager'  => $this->bookModel->pager,
        ];
        return view('libreria/catalogo', $data);
    }
    /**
     * Agrega un libro al carrito en sesión con validación de stock
     */
    public function add()
    {
        $id = $this->request->getPost('id_libro');
        $cantidad = (int) $this->request->getPost('cantidad');
        $formato = $this->request->getPost('formato') ?? 'Físico';
        $libro = $this->bookModel->obtenerConAutor($id);
        if (!$libro) {
            return redirect()->back()->with('error', 'El libro especificado no existe.');
        }
        if ($cantidad <= 0 || $cantidad > $libro['stock']) {
                return redirect()->back()->with('error', 'La cantidad solicitada supera el stock disponible (Max: ' . $libro['stock'] . ').');
        }
        $carrito = $this->session->get('libro_carrito') ?? [];
        $itemKey = $libro['isbn'] . '_' . str_replace(' ', '', $formato);
        if (isset($carrito[$itemKey])) {
            $nuevaCantidad = $carrito[$itemKey]['cantidad'] + $cantidad;
            if ($nuevaCantidad > $libro['stock']) {
                return redirect()->back()->with('error', 'No puedes agregar más unidades. Supera el stock actual.');
            }
            $carrito[$itemKey]['cantidad'] = $nuevaCantidad;
            $carrito[$itemKey]['subtotal'] = $carrito[$itemKey]['cantidad'] * 
            $carrito[$itemKey]['precio'];
        } else {
            $carrito[$itemKey] = [
                'id'       => $libro['id_libro'],
                'isbn'     => $libro['isbn'],
                'titulo'   => $libro['titulo'],
                'autor'    => $libro['autor'],
                'formato'  => $formato,
                'precio'   => (float) $libro['precio'],
                'stock'    => (int) $libro['stock'],
                'cantidad' => $cantidad,
                'subtotal' => $cantidad * (float) $libro['precio'],
                'portada'  => $libro['portada'] 
            ];
        }
        
        $this->session->set('libro_carrito', $carrito);
        return redirect()->to(site_url('libreria/carrito'))->with('success', 'Libro agregado a tu carrito.');
    }
    /**
     * Visualizar los libros en el carrito y calcular el total
     */
    public function show()
        {
            $carrito = $this->session->get('libro_carrito') ?? [];
            $total = 0;

            // Actualizamos el stock en tiempo real antes de enviar a la vista
            foreach ($carrito as $key => &$item) {
                $libroActual = $this->bookModel->where('isbn', $item['isbn'])->first();
                if ($libroActual) {
                    $item['stock'] = (int) $libroActual['stock'];
                }
                $total += $item['subtotal'];
            }

            // Guardamos los stocks actualizados en la sesión
            $this->session->set('libro_carrito', $carrito);

            $data['carrito'] = $carrito;
            $data['total']   = $total;
            
            return view('libreria/carrito', $data);
        }
    /**
     * Elimina un ítem específico usando su llave en el arreglo de sesión
     */
    public function remove($itemKey)
    {
        $carrito = $this->session->get('libro_carrito') ?? [];
        if (isset($carrito[$itemKey])) {
            unset($carrito[$itemKey]);
            $this->session->set('libro_carrito', $carrito);
        }
        return redirect()->to(site_url('libreria/carrito'))->with('success', 'Ejemplar quitado del carrito.');
    }
    /**
     * Limpia completamente la clave de sesión del carrito
     */
    public function clear()
    {
        $this->session->remove('libro_carrito');
        return redirect()->to(site_url('libreria/carrito'))->with('success', 'Carrito de libros vaciado.');
    }
    public function finalizar()
    {
        $carrito = $this->session->get('libro_carrito') ?? [];

        if (empty($carrito)) {
            return redirect()->to(site_url('libreria/carrito'))->with('error', 'Tu carrito está vacío.');
        }

        // Verificación previa (mensaje amigable, no es la garantía real)
        foreach ($carrito as $item) {
            $libroActual = $this->bookModel->where('isbn', $item['isbn'])->first();

            if (! $libroActual) {
                return redirect()->to(site_url('libreria/carrito'))
                    ->with('error', "El libro \"{$item['titulo']}\" ya no está disponible.");
            }

            if ($libroActual['stock'] < $item['cantidad']) {
                return redirect()->to(site_url('libreria/carrito'))
                    ->with('error', "Ya no hay suficiente stock de \"{$item['titulo']}\" (disponible: {$libroActual['stock']}).");
            }
        }

        $db           = \Config\Database::connect();
        $ventaModel   = new VentaModel();
        $detalleModel = new DetalleVentaModel();
        $total        = array_sum(array_column($carrito, 'subtotal'));

        $db->transStart();

        $idVenta = $ventaModel->insert([
            'fecha'      => date('Y-m-d H:i:s'),
            'total'      => $total,
            'estado'     => 'pagado',
            'usuario_id' => session()->get('id_usuario'),
            
        ], true);

        foreach ($carrito as $item) {
            $detalleModel->insert([
                'id_venta' => $idVenta,
                'isbn'     => $item['isbn'],
                'cantidad' => $item['cantidad'],
                'precio'   => $item['precio'],
                'subtotal' => $item['subtotal'],
            ]);

            // La garantía real: solo descuenta si en ESTE instante todavía alcanza
            $db->query(
                'UPDATE libros SET stock = stock - ? WHERE isbn = ? AND stock >= ?',
                [$item['cantidad'], $item['isbn'], $item['cantidad']]
            );

            if ($db->affectedRows() === 0) {
                $db->transRollback();
                return redirect()->to(site_url('libreria/carrito'))
                    ->with('error', "El stock de \"{$item['titulo']}\" cambió justo antes de tu compra. Revisa tu carrito.");
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(site_url('libreria/carrito'))
                ->with('error', 'No se pudo completar la compra. Intenta de nuevo.');
        }

        $this->session->remove('libro_carrito');

        return redirect()->to(site_url('libreria/catalogo'))
            ->with('success', "¡Compra #{$idVenta} realizada con éxito! Total: $" . number_format($total, 2));
    }
}