
@extends("front.$version.layout")
@section('content')

  <!-- Page-wrapper-Start -->


  <div class="page_wrapper">

    <!-- Preloader -->
    <div id="preloader">
      <div id="loader"></div>
    </div>

    <div class="full_bg">

      <div class="container">
         <section class="signup_section">

          <div class="top_part">
            <a href="index.html" class="back_btn"><i class="icofont-arrow-left"></i> Back</a>
            <a class="navbar-brand" href="#">
              <img src="images/footer_logo.png" alt="image">
            </a>
          </div>

          <!-- Comment Form Section -->
          <div class="signup_form">
            <div class="section_title">
              <h2> <span>Create</span> an account</h2>
              <p>Fill all fields so we can get some info about you. <br> We'll never send you spam</p>
            </div>
            <form action="{{route('register-user')}}" method="POST">
                @csrf
              <div class="form-group">
                <input type="text" name="full_name" class="form-control" placeholder="Name">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" name="email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password">
              </div>
              <div class="form-group">
                <button class="btn puprple_btn" type="submit">SIGN UP</button>
              </div>
            </form>
            <p class="or_block">
              <span>OR</span>
            </p>
           <div class="or_option">
              <p>Sign up with your work email</p>
              <a href="#" class="btn google_btn"><img src="images/google.png" alt="image"> <span>Sign Up with Google</span> </a>
              <p>Already have an account? <a href="#">Sign In here</a></p>
           </div>
          </div>
         </section>
      </div>

    </div>
  </div>

  @endsection

