@extends('admin/app')
@section('content')

<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Pictures</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pictures</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Pictures Table</h3>

                    <a href="{{route('pictures.create')}}" class="btn btn-primary " style="float:right">Add New</a>
                </div>


                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pictures as $picture)
                            <tr class="align-middle">
                          
                                <td>{{ucfirst($picture->type)}}</td>
                                <td>
                                    <img src="{{asset('assets/pictures/'.$picture->image)}}" loading="lazy" width="130" alt="$picture->image">
                                </td>
                                <td>
                                    @if($picture->status == 1)
                                    <span class="badge text-bg-success">Active</span>
                                    @else 
                                    <span class="badge text-bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    {{date('M j, Y', strtotime($picture->created_at))}}
                                </td>
                                <td>
                                    <a href="{{route('pictures.edit', $picture->id)}}"><i class="bi bi-pencil-square btn btn-info"></i></a>
                                    <a href="#" onclick="deletePicture('{{$picture->id}}')"><i class="bi bi-trash btn btn-danger"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr class="align-middle">
                                <td colspan="5" class="text-center">No data found.</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</main>




@endsection

@section('scripts')
<script>
    function deletePicture(id)
    {
        Swal.fire({
            'title':'Are you sure?',
            'icon':'warning',
            showCancelButton:true,
            confirmButtonText: 'Yes, delete it'
        }).then((res)=>{
            if(res.isConfirmed){
                $.ajax({
                    url: "{{url('pictures/delete')}}/"+id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        Swal.fire(
                            "Deleted!",
                            "Picture deleted successfully",
                            "success",
                        ).then(()=>{
                            location.reload();
                        });
                    }
                });
            }
        });
    }
</script>
@endsection