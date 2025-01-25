<form action="{{ route('materials.con') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="images">画像を選択（複数可）:</label>
    <input type="file" name="images[]" id="images" multiple>
    <button type="submit">アップロード</button>
</form>
