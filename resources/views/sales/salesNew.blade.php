@extends('sales.sales')

@section('subcontent')
<br><br>
<form class="form-inline">
  <div class="form-group">
    <label for="CustomerList">Cliente:</label>
    <select class="form-control" name="CustomerList">
        @foreach ($customer as $cust)

            <option>{{$cust->CUSTNAME}}</option>

        @endforeach
    </select>
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <div class="form-group">
    <label for="ListList">Lista:</label>
    <select class="form-control" name="ListList">
        @foreach ($listheader as $list)

            <option>{{$list->LISTNAME}}</option>

        @endforeach
    </select>
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <div class="form-group">
    <label for="DescriptionText">Descripcion:</label>
    <input type="text" class="form-control" name = "DescriptionText">
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <button type="submit" class="btn btn-default">Crear</button>
</form>

@endsection