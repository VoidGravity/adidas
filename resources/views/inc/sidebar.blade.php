<aside class="sidebar position-fixed top-0 left-0 overflow-auto h-100 float-left" id="show-side-navigation1">

    <div class="sidebar-header d-flex justify-content-center align-items-center px-3 py-4">
        <img class="rounded-pill img-fluid" width="65"
            src="https://uniim1.shutterfly.com/ng/services/mediarender/THISLIFE/021036514417/media/23148907008/medium/1501685726/enhance"
            alt="">
        <div class="ms-2">
            <h5 class="fs-6 mb-0">
                <a class="text-decoration-none" href="#">Abidas Official</a>
            </h5>

            <p class="mt-1 mb-0">Abdias a7san site dyal t9acher fl3alem, sl3a n9ya mn tanger</p>
        </div>
    </div>


    <div class="search position-relative text-center px-4 py-3 mt-2">
        {{-- I need to add a condition for the search to switch based on the area --}}
        <form action="{{ url('search') }}" method="POST" class="d-flex justify-content-between">
            @csrf
            <input type="text" id="liveSearchInput" class="form-control w-100 border-0" placeholder="Search here">

            {{-- <input name="search" type="text" class="form-control w-100 border-0" placeholder="Search here"> --}}
           
            <button id="search" type="submit" class="btn btn-primary m-1">Search</button>

        </form>
    </div>

    <ul class="categories list-unstyled">
        <li>
            <a href="{{ url('product') }}"> Product</a>

        </li>
        <tr></tr>
        <li>
            <a href="{{ url('category') }}">Category</a>
        </li>
        <li>
            <a href="{{ route('sales.index') }}">Sales</a>
       
        </li>
        {{-- <li>
            <a href="{{ route('client.index') }}">Clients</a>
        </li> --}}
        <li>
            <a href="{{ route('permission.index') }}">Permissions</a>
        </li>
        <li>
            <a href="{{ route('role.index') }}">Role</a>
        </li>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#liveSearchInput').on('keyup', function() {
                    var query = $(this).val();
                    $.ajax({
                        url: "{{ url('search') }}",
                        type: "GET",
                        data: {'search': query},
                        success: function(data) {
                            $('tbody').html(data);
                        }
                    });
                });
            });
        </script>
        
        

    </ul>
</aside>
