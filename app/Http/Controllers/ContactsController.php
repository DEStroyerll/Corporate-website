<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactsController extends SiteController
{
    //
    public function __construct()
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->site_bar = 'left';
        $this->title = 'Contact';

        $this->template = env('THEME') . '.contacts';
    }

    public function index(Request $request)
    {
        //isMethod проверяет какой тип запроса использует пользователь.
        if ($request->isMethod('post')) {
            //Обращаясь к объекту класса IndexController мы вызываем метод validate.
            $this->validate($request, [
                //Поля required обязательные к заполнению.
                'Name' => 'required|max:255',
                'Email' => 'required|email',
                'Message' => 'required'
            ]);
            //Сохраняем в переменную $data данные отправленные пользователем.
            $data = $request->all();

            //Используя фасад Mail мы отправляем сообщение на определенный почтовый ящик.
            //В методе send() первым параметром мы используем шаблон письма,
            //вторым параметром мы используем массив с данными который заполнил пользователь.
            $send_message = Mail::send(env('THEME') . '.email', ['data' => $data], function ($message) use ($data) {

                //Для получения доступа к переменным которые хранятся в файле .env
                //мы используем одноименную функцию-хелпер env().
                $mail_admin = env('MAIL_ADMIN');

                //Здесь мы определяем от кого отправляем письмо.
                $message->from($data['email'], $data['name']);
                //Здесь мы определяем кому отправляем письмо и задаем тему.
                $message->to($mail_admin, 'Admin')->subject('I wrote a letter.');

            });
            //Здесь мы после отправки сообщения возвращаем пользователя на страничку 'contacts'.
            if ($send_message) {
                return redirect()
                    ->route('contacts')
                    ->with('status', 'Message sent successfully!');
            }
        }


        $content = view(env('THEME') . '.contact_content')->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $this->content_left_sidebar = view(env('THEME') . '.contact_sidebar')->render();

        return $this->renderOutput();
    }
}
