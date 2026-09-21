<?php 
namespace App\Controllers;

use app\Models\BookModel;

class BookController extends BaseController{

    public function index()
    {
        helper(['form']);
        return view('FormBook'); // respeta mayúsculas exactas del archivo real
    }
    public function save()
    {
        $bookModel = new BookModel();
        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'isbn' => $this->request->getPost('isbn'),
            'formato' => $this->request->getPost('formato'),
            'portada' => $this->request->getPost('portada'),
            'precio' => $this->request->getPost('precio'),
            'stock' => $this->request->getPost('stock'),
        ];
        $bookModel->insert($data);
        return redirect()->to('/libreria/catalogo');

}
}