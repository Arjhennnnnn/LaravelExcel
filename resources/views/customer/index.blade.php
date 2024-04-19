<div>
    <p>Import Excel Data</p>

    <form action="{{ url('customer/import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <input type="file" name="import_file">

        <button type="submit">Import</button>
    </form>

    <p>Export Excel Data</p>


    <form action="{{ url('customer/export') }}" method="get">

        <select name="type">

            <option value="">Select Type</option>

            <option value="xlsx">XLSX</option>

            <option value="csv">CSV</option>

            <option value="xls">XLS</option>

        </select>

        <button type="submit"> Export / Download </button>

    </form>

</div>