@extends('layouts.app')

@section('content')
    <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            @if ( Session::has('flash_message') )

              <div class="alert {{ Session::get('flash_type') }}">
                  <p>{{ Session::get('flash_message') }}</p>
              </div>

            @endif
            @if(Auth::user()->role=='admin')
                <a class="btn btn-primary mb-4 text-right" href="{{route('create.vehicle')}}">Add Vehicle</a>
            @endif
            <div class="card">
                @if(isset($vehicles) && !empty($vehicles))
                    <div class="card-body">
                        <p class="align-left">Vehicles List</p>
                    </div>
                    <table class="table table-striped vehicle_table">
                       <thead>
                         <tr>
                           <th>ID</th>
                           <th>Type</th>
                           <th>Brand</th>
                           <th>Max passenger number</th>
                           <th>Action</th>
                         </tr>
                       </thead>
                       <tbody>
                            @foreach($vehicles as $vehicle)
                              <tr>
                                 <td>{{$vehicle->id}}</td>
                                 <td>{{$vehicle->type}}</td>
                                 <td>{{$vehicle->brand}}</td>
                                 <td>{{$vehicle->max_passenger_number}}</td>
                                 <td>
                                     <form class="form-inline" method="POST" action="{{ route('add.booking',['vehicle_id' => $vehicle->id]) }}">
                                      {{ csrf_field() }}
                                         <div class="form-group">
                                            @php
                                                if(count($vehicle->booked_vehicles) > 0){
                                                   $vehicle_booked_date = $vehicle->booked_vehicles[0]->pivot->booked_date; 
                                                }else {
                                                    $vehicle_booked_date = "";
                                                }
                                            @endphp
                                            <input date-booked_date="{{ $vehicle_booked_date}}" class="form-control select_booking_date mr-2" type="text" name="booked_date" placeholder="Select booking date" />
                                            <button id="datepicker"  type="submit" class="btn btn-primary">
                                                Book
                                            </button>
                                         </div>
                                     </form>
                                    @if ($errors->any())
                                        <div class="errors_div">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                 </td>
                                  @if(Auth::user()->role=='admin')
                                      <td>
                                          <form action="{{route('vehicle.destroy',[$vehicle->id])}}" method="POST">
                                                @method('DELETE')
                                               {{ csrf_field() }}
                                              <button  type="submit" class="btn btn-danger">
                                                  Delete
                                              </button>
                                          </form>
                                      <td>
                                  @endif
                              </tr>
                            @endforeach
                       </tbody>
                     </table>
                @else
                    <p>No vehicles exist</p>
                @endif
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            @if ( Session::has('flash_booking_message') )

              <div class="alert {{ Session::get('flash_type') }}">
                  <p>{{ Session::get('flash_booking_message') }}</p>
              </div>

            @endif
            <div class="card my_bookings">
                <div class="card-body">
                    @if(!empty(Auth::user()->booked_vehicles) && count(Auth::user()->booked_vehicles)  > 0)
                        <p>My bookings</p>
                        <table class="table table-striped vehicle_table">
                               <thead>
                                 <tr>
                                    <th>ID</th>
                                    <th>Booked vehicle type</th>
                                    <th>Booked vehicle brand</th>
                                    <th>Booked Date</th>
                                    <th>Action</th>
                                 </tr>
                               </thead>
                               <tbody>
                                    @foreach(Auth::user()->booked_vehicles as $my_booked_vehicle)
                                      <tr>
                                        <td>{{$my_booked_vehicle->id}}</td>
                                        <td>{{$my_booked_vehicle->type}}</td>
                                        <td>{{$my_booked_vehicle->brand}}</td>
                                        <td>{{$my_booked_vehicle->pivot->booked_date}}</td>
                                        <td>
                                            <form action="{{route('booking.cancel',[$my_booked_vehicle->id])}}" method="POST">
                                                @method('DELETE')
                                               {{ csrf_field() }}
                                              <button  type="submit" class="btn btn-danger">
                                                  Cancel Book
                                              </button>
                                            </form>
                                        <td>
                                      </tr>
                                    @endforeach
                               </tbody>
                        </table>
                    @else
                        <p>There is no booked vehicles</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .errors_div {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    .errors_div ul {
        margin-top: 5px;
        padding: 5px 0 5px 20px;
    }
    .my_bookings {
        margin-top: 20px;
    }
</style>
<script type="text/javascript">
     $(document).ready(function() {

        var dateToday = new Date();
        dateToday.setDate(dateToday.getDate());
        var bookedDates = [];
        $('.select_booking_date').click(function(){
            bookedDates.push($(this).attr("date-booked_date"))
        })
        
        $('.select_booking_date').datepicker({
            dateFormat: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: "auto",
            startDate: dateToday,
            beforeShowDay: function(d) {
                if(bookedDates){
                    var year = d.getFullYear(),
                        month = ("0" + (d.getMonth() + 1)).slice(-2),
                        day = ("0" + (d.getDate())).slice(-2);
                    var formattedData = year + '-' + month + '-' + day;
                   if ($.inArray(formattedData, bookedDates) < 0)
                        return [true,'free','Book Now'];
                    else
                        return [false,'disabled','Booked out'];
                }
            }
        });

        $(".alert").delay(8000).hide(8000);
     });
</script>
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>


@endsection
