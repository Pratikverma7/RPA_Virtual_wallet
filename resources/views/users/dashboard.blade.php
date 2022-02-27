@extends('users.header')
@section('content')
<br>
<br>
<a href="{{url('logout')}}"><button class="btn btn-primary">Logout</button></a>
<br>
<br>

<div class="card">
    <div class="card-body">
        <br>
        <h4 class="text-center text-dark">Welcome {{Auth::user()->name}} To Virtual Wallet </h4>
        <div class="card bg-warning"></div>
        <br><br>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
            <strong>{{ $message }}</strong>
            </div>
        @endif
        
        @if ($message = Session::get('balance'))
            <div class="alert alert-danger alert-block">
            <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="card bg-success">
            <div class="row" style="margin:30px">
                <div class="col-md-6">
                     <h5 class="text-left text-light"><i> Available Wallet Amount : </i></h5>
                </div>

                <div class="col-md-6">
                <?php
                $total_balance = $user_wallet_amount = $credit- $debit;
                ?>
                <h5 class="text-right text-light"> &#x20B9; <?php echo $total_balance ?>.00</h5>
                </div>
            </div>
            <br>
            <span class="text-white">Note: &#x20B9; 500 is Your Deafult Amount to make Transactions </span>
        </div>
        <br><br>
        <div class="row">
          
            <div class="col-md-12">
              <!-- Button trigger modal -->
               <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     SEND AMOUNT
                </button>

                 <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Credit Amount</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                       <div class="modal-body">
                       <form method="POST" action="{{url('transction/credit')}}">
                         @csrf
                          <div class="mb-3">
                               <input type="hidden" name="from_user_id" value="{{Auth::user()->email}}">
                               <label for="exampleInputEmail1" class="form-label">Email</label>
                               <input type="email" class="form-control"aria-describedby="emailHelp" name="to_user_id">
                          </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Amount</label>
                                <input type="number" class="form-control" name="amount">
                            </div>

                           <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                   </div>
                </div>
              </div>
            </div>
        </div>
  </div>
</div>
          
    </div>
</div>
<br><br>
<section>
    <h3 class="text-center text-info"><i>Your Tansaction History</i></h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">S.no</th>
      <th scope="col">Amount</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
      <th scope="col">Credit/Debit</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <?php 
    $i = 1;
  ?>
  <tbody>
      @foreach($history as $h)
    <tr>
      <th scope="row"><?php echo $i++ ?></th>
      <td>
          @if($h->action == 'c')
          <span class="text-success"> &#x20B9; {{$h->amount}} </span>
          @else
          <span class="text-danger">  &#x20B9;{{$h->amount}}</span>
          @endif
      </td>
      <td>{{$h->from_user_id}}</td>
      <td>{{$h->to_user_id}}</td>
      <td>
          @if($h->to_user_id == Auth::user()->email)
          
          <span class="text-success">CREDITED</span>
          @else
          <span class="text-danger">DEBITED</span>
          @endif
      </td>
      <td>{{$h->created_at}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</section>
@endsection