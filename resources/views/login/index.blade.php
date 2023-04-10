@extends('layout.app')

@section('Titulo', 'Sage2.0 - Autenticacion')

@section('ContenidoPrincipal')
<body class="lock-screen" onload="startTime()">

  <div class="lock-wrapper">

    <div id="time" style="color:rgb(74, 71, 71)"></div>


    <div class="card text-center bg-op-1">
      <img src="{{ asset('img/seguridad.jpg');}}" alt="lock avatar"/>
      <div class="card-body">
        <h1><strong style="color:rgb(74, 71, 71)">Sistema <strong><strong style="color: rgb(75, 15, 15)">SAGE</strong></h1>
        <span class="locked">{{$mensajeError}}</span>
        <form role="form" class="form-group" method="POST" action="{{ route('login') }}">
          @csrf
            <div class="form-group">
              <input type="email" placeholder="Email" id="email" name="email" class="form-control mb-2">
              <input type="password" placeholder="Password" id="password" name="clave" class="form-control">
            </div>
                  
            <div class="form-group">
              <button class="btn btn-block btn-success btn-lg" type="submit">
                  <i class="fa fa-arrow-right"></i>
              </button>
            </div>
                
        </form>
      </div>
    </div>
  </div>
</body>
@endsection

@section('Script')
<script>
  function startTime()
  {
      var today=new Date();
      var h=today.getHours();
      var m=today.getMinutes();
      var s=today.getSeconds();
      // add a zero in front of numbers<10
      m=checkTime(m);
      s=checkTime(s);
      document.getElementById('time').innerHTML=h+":"+m+":"+s;
      t=setTimeout(function(){startTime()},500);
  }

  function checkTime(i)
  {
      if (i<10)
      {
          i="0" + i;
      }
      return i;
  }
</script>
@endsection