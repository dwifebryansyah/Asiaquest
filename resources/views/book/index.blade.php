<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <title>Book</title>
</head>
<body>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category') }}">Category</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('book') }}">Book</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
    </ul>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Create Buku
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form action="{{ route('store_book') }}" method="post">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tittle</label>
                    <input type="text" class="form-control" name="tittle" required="">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Description</label>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Category</label>
                    <select data-placeholder="Choose a country..." name="category[]" multiple class="chosen-select" required="">
                        @foreach($category as $data)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Keywords</label>
                    <input type="text" class="form-control" name="keyword" required="">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Price</label>
                    <input type="number" class="form-control" id="harga" name="price" required="">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" required="">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Publisher</label>
                    <input type="text" class="form-control" name="publisher" required="">
                </div>
            </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </div>
    </form>
    </div>
    </div>

    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Description</th>
                <th>Kategory</th>
                <th>Keywords</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Penerbit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1  @endphp
            @foreach($book as $data)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data->tittle }}</td>
                <!-- <td>{{ substr($data->description,0,100) }} ...</td> -->
                <td>
                    {{ substr($data->description,0,100) }}
                    <span id="more{{$data->id}}" style="display:none;">
                        {{ substr($data->description,100)}}
                    </span>
                    <a href="javascript:showMore({{ $data->id }})" id="link{{$data->id}}"> ...</a>
                </td>
                <td>{{ $data->category }}</td>
                <td>{{ $data->keywords }} </td>
                <td>Rp. {{ number_format($data->price, 0, ',', '.') }}</td>
                <td>{{ $data->stock }}</td>
                <td>{{ $data->publisher }}</td>
                <td>
                    <a href="{{ route('destroy_book',['id' => $data->id]) }}" onclick="return confirm('Apakah anda yakin?')">Delete</a>
                    <a href="{{ route('edit_book',['id' => $data->id]) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

    function showMore(id){
        //removes the link
        document.getElementById('link'+id).style.display = "none";
        //shows the #more
        console.log('ada');
        document.getElementById('more'+id).style.display = "block";
    }
</script>
<script>
        var harga = document.getElementById('harga');

        harga.addEventListener('mouseout', function(e) {
            var harga_now = this.value;
            harga.value = formatRupiah(harga_now, '');
        });
        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
</script>