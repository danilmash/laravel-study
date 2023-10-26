<form method="post" action="{{ route('articles.store') }}">
    @csrf
    <label for="title">Заголовок:</label>
    <input type="text" name="title" id="title">
    <br>
    <label for="content">Содержимое:</label>
    <textarea name="content" id="content"></textarea>
    <br>
    <button type="submit">Добавить запись</button>
</form>
