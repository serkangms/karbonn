@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        İletişim Form Gönderileri
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="content pt-0"> <!-- Center the card on the page -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <table class="table table-lg table-striped">
                            <thead>
                            <tr>
                                <th>Adı</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>E-Posta</th>
                                <th>Tarih</th>
                                <th class="text-center">Durum</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{\Carbon\Carbon::parse($item->created_at)->format('d.m.Y')}}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <div class="dropdown">
                                                <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                    <i class="ph-list"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('admin.Contact.delete', $item->id) }}" class="dropdown-item">
                                                        <i class="ph-trash-simple me-2"></i>
                                                        Sil
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


