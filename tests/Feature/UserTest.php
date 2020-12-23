<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function user_auth_login_view()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/login');

        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_auth_login()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/login',[
            'email'=>'adminuser2020@gmail.com',
            'password'=>'adminuser10'
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function user_auth_register_view()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/register');

        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function user_create_account()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name'=>'aymane10',
            'email'=>'aymane'.rand(1,1000).'@gmail.com',
            'password'=>'aymane110',
            'password_confirmation'=>'aymane110',
            'role'=>'employe'
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function user_log_out()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('logout');

        $response->assertRedirect('/');
    }

    /** @test */
    public function user_show_view()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('logout');

        $response->assertRedirect('/');
    }
}
