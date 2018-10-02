<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artı Metrik</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="{{asset('css/odyometri.css')}}" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h1 class="my-0 mr-md-auto font-weight-normal">Artı Metrik</h1>

</div>
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isset($message))
        <div class="alert alert-success">
            <ul>
                <li>{{ $message }}</li>
            </ul>
        </div>
    @endif
    <h4 class="display-7">Odyometri</h4>
    <button type="button" class="btn btn-default btn-circle btn-lg" data-toggle="modal"
            data-target="#createModal"><i class="fa fa-plus"></i></button>
    <div class="pt-lg-3"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <ul class="list-group odyometriList">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="col-md-10 text-left" >
                        <span class="checkBox">
                            <input type="checkbox" id="selectAll" >
                        </span>
                        Tümünü Seç
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-light" onclick="comparison()"><i
                                class="fa fa-exchange-alt" title="Karşılaştır"></i></button>

                    </div>
                </li>
                @foreach($data as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        id="List{{$item->id}}">
                        <div class="col-md-10 text-left">
                            <span class="checkBox"><input type="checkbox" name="" id="{{$item->id}}"
                                                          onclick="checkedItem({{$item->id}})"></span>
                            Odyometri - ( {{ \Carbon\Carbon::parse($item->date)->format('d.m.Y')}} )
                        </div>
                        <div class="col-md-2 text-right">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#editModal"
                                        id="{{$item->id}}" onclick="editOdyometri(this.id)">
                                    <i class="fa fa-pen"></i>
                                </button>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-light" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <button class="btn btn-primary dropdown-item" onclick="showItem({{$item->id}})">
                                            Görüntüle
                                        </button>
                                        <button class="btn btn-danger dropdown-item"
                                                onclick="deleteItem({{$item->id}})">Sil
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>

            <!--CREATE Modal -->
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLongTitle">Odyometri</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('create')}}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="inlineInput">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tahlil/Tetkik Tarihi</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="date"><i
                                                        class="fa fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="date" id="date"
                                                   placeholder="date" aria-label="date" aria-describedby="date"
                                                   required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Kanaat</label>
                                        <input type="text" class="form-control" name="comment" id="comment"
                                               maxlength="255">
                                        <h6 class="text-right" id="message"></h6>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Sonuç</label>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <td scope="col">250 Hz</td>
                                                <th scope="col">500 Hz</th>
                                                <th scope="col">1 kHz</th>
                                                <th scope="col">2 kHz</th>
                                                <td scope="col">3 kHz</td>
                                                <td scope="col">4 kHz</td>
                                                <td scope="col">6 kHz</td>
                                                <td scope="col">8 kHz</td>
                                                <td scope="col">SSO</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">Sol Kulak</th>
                                                <td><input class="tableInput" type="text" name="L250hz" id="L250hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="L500hz" id="L500hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="L1khz" id="L1khz"></td>
                                                <td><input class="tableInput" type="text" name="L2khz" id="L2khz"></td>
                                                <td><input class="tableInput" type="text" name="L3khz" id="L3khz"></td>
                                                <td><input class="tableInput" type="text" name="L4khz" id="L4khz"></td>
                                                <td><input class="tableInput" type="text" name="L6khz" id="L6khz"></td>
                                                <td><input class="tableInput" type="text" name="L8khz" id="L8khz"></td>
                                                <td><input class="tableInput" type="text" name="LSSO" id="LSSO"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Sağ Kulak</th>
                                                <td><input class="tableInput" type="text" name="R250hz" id="R250hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="R500hz" id="R500hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="R1khz" id="R1khz"></td>
                                                <td><input class="tableInput" type="text" name="R2khz" id="R2khz"></td>
                                                <td><input class="tableInput" type="text" name="R3khz" id="R3khz"></td>
                                                <td><input class="tableInput" type="text" name="R4khz" id="R4khz"></td>
                                                <td><input class="tableInput" type="text" name="R6khz" id="R6khz"></td>
                                                <td><input class="tableInput" type="text" name="R8khz" id="R8khz"></td>
                                                <td><input class="tableInput" type="text" name="RSSO" id="RSSO"></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">İptal</button>
                                <button type="submit" class="btn btn-success">KAYDET</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--SHOW Modal -->
            <div class="modal fade" id="showModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLongTitle">Odyometri</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="inlineInput">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tahlil/Tetkik Tarihi</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="date"><i
                                                        class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="date" id="date"
                                               placeholder="date" aria-label="date" aria-describedby="date"
                                               required="required" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Kanaat</label>
                                    <input type="text" class="form-control" name="comment" id="comment"
                                           maxlength="255" disabled>
                                    <h6 class="text-right" id="message"></h6>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Sonuç</label>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <td scope="col">250 Hz</td>
                                            <th scope="col">500 Hz</th>
                                            <th scope="col">1 kHz</th>
                                            <th scope="col">2 kHz</th>
                                            <td scope="col">3 kHz</td>
                                            <td scope="col">4 kHz</td>
                                            <td scope="col">6 kHz</td>
                                            <td scope="col">8 kHz</td>
                                            <td scope="col">SSO</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">Sol Kulak</th>
                                            <td><input class="tableInput" type="text" name="L250hz" id="L250hz"
                                                       disabled></td>
                                            <td><input class="tableInput" type="text" name="L500hz" id="L500hz"
                                                       disabled></td>
                                            <td><input class="tableInput" type="text" name="L1khz" id="L1khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="L2khz" id="L2khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="L3khz" id="L3khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="L4khz" id="L4khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="L6khz" id="L6khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="L8khz" id="L8khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="LSSO" id="LSSO" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Sağ Kulak</th>
                                            <td><input class="tableInput" type="text" name="R250hz" id="R250hz"
                                                       disabled></td>
                                            <td><input class="tableInput" type="text" name="R500hz" id="R500hz"
                                                       disabled></td>
                                            <td><input class="tableInput" type="text" name="R1khz" id="R1khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="R2khz" id="R2khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="R3khz" id="R3khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="R4khz" id="R4khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="R6khz" id="R6khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="R8khz" id="R8khz" disabled>
                                            </td>
                                            <td><input class="tableInput" type="text" name="RSSO" id="RSSO" disabled>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">KAPAT</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--EDIT Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLongTitle">Odyometri</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('update')}}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="inlineInput">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tahlil/Tetkik Tarihi</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="date"><i
                                                        class="fa fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" name="date" id="date"
                                                   placeholder="date" aria-label="date" aria-describedby="date"
                                                   required="required" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Kanaat</label>
                                        <input type="text" class="form-control" name="comment" id="comment"
                                               maxlength="255" value="">
                                        <h6 class="text-right" id="message"></h6>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Sonuç</label>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <td scope="col">250 Hz</td>
                                                <th scope="col">500 Hz</th>
                                                <th scope="col">1 kHz</th>
                                                <th scope="col">2 kHz</th>
                                                <td scope="col">3 kHz</td>
                                                <td scope="col">4 kHz</td>
                                                <td scope="col">6 kHz</td>
                                                <td scope="col">8 kHz</td>
                                                <td scope="col">SSO</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">Sol Kulak</th>
                                                <td><input class="tableInput" type="text" name="L250hz" id="L250hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="L500hz" id="L500hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="L1khz" id="L1khz"></td>
                                                <td><input class="tableInput" type="text" name="L2khz" id="L2khz"></td>
                                                <td><input class="tableInput" type="text" name="L3khz" id="L3khz"></td>
                                                <td><input class="tableInput" type="text" name="L4khz" id="L4khz"></td>
                                                <td><input class="tableInput" type="text" name="L6khz" id="L6khz"></td>
                                                <td><input class="tableInput" type="text" name="L8khz" id="L8khz"></td>
                                                <td><input class="tableInput" type="text" name="LSSO" id="LSSO"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Sağ Kulak</th>
                                                <td><input class="tableInput" type="text" name="R250hz" id="R250hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="R500hz" id="R500hz">
                                                </td>
                                                <td><input class="tableInput" type="text" name="R1khz" id="R1khz"></td>
                                                <td><input class="tableInput" type="text" name="R2khz" id="R2khz"></td>
                                                <td><input class="tableInput" type="text" name="R3khz" id="R3khz"></td>
                                                <td><input class="tableInput" type="text" name="R4khz" id="R4khz"></td>
                                                <td><input class="tableInput" type="text" name="R6khz" id="R6khz"></td>
                                                <td><input class="tableInput" type="text" name="R8khz" id="R8khz"></td>
                                                <td><input class="tableInput" type="text" name="RSSO" id="RSSO"></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">İptal</button>
                                <button type="submit" class="btn btn-success">KAYDET</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--COMPARISON Modal -->
            <div class="modal fade" id="comparisonModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLongTitle">Odyometri Fark Tablosu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#left" role="tab"
                                       aria-controls="home" aria-selected="true">Sol Kulak</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#right" role="tab"
                                       aria-controls="profile" aria-selected="false">Sağ Kulak</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="left" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless" id="LeftEar">
                                            <thead>
                                            <tr>
                                                <th scope="col">Tarih</th>
                                                <td scope="col">250 Hz</td>
                                                <th scope="col">500 Hz</th>
                                                <th scope="col">1 kHz</th>
                                                <th scope="col">2 kHz</th>
                                                <td scope="col">3 kHz</td>
                                                <td scope="col">4 kHz</td>
                                                <td scope="col">6 kHz</td>
                                                <td scope="col">8 kHz</td>
                                                <td scope="col">SSO</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr style="border-top: 1px solid gray;">
                                                <td scope="row" id="days"></td>
                                                <td id="difL250hz"></td>
                                                <td id="difL500hz"></td>
                                                <td id="difL1khz"></td>
                                                <td id="difL2khz"></td>
                                                <td id="difL3khz"></td>
                                                <td id="difL4khz"></td>
                                                <td id="difL6khz"></td>
                                                <td id="difL8khz"></td>
                                                <td id="difLSSO"></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="right" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless" id="RightEar">
                                            <thead>
                                            <tr>
                                                <th scope="col">Tarih</th>
                                                <td scope="col">250 Hz</td>
                                                <th scope="col">500 Hz</th>
                                                <th scope="col">1 kHz</th>
                                                <th scope="col">2 kHz</th>
                                                <td scope="col">3 kHz</td>
                                                <td scope="col">4 kHz</td>
                                                <td scope="col">6 kHz</td>
                                                <td scope="col">8 kHz</td>
                                                <td scope="col">SSO</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr style="border-top: 1px solid gray;">
                                                <td scope="row" id="RightDays"></td>
                                                <td id="difR250hz"></td>
                                                <td id="difR500hz"></td>
                                                <td id="difR1khz"></td>
                                                <td id="difR2khz"></td>
                                                <td id="difR3khz"></td>
                                                <td id="difR4khz"></td>
                                                <td id="difR6khz"></td>
                                                <td id="difR8khz"></td>
                                                <td id="difRSSO"></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/odyometri.js') }}" type="text/javascript"></script>

</body>
</html>
