@extends('layouts.base')

@section('title', 'Регистрация')

@section('content')
    <h1>Регистрация</h1>
    <form method="post" action="{{ route('registration') }}">
        @csrf <!-- Добавление CSRF-токена -->
        <label for="name">Имя:</label>
        <input type="text" name="name" id="name">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="Зарегистрироваться">
    </form>
@endsection