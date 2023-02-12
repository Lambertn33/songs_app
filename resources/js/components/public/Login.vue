<template>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="login-div">
        <div class="login-header">
          <h2>{{ loginTitle }}</h2>
          <h5>{{ loginSubtitle }}</h5>
        </div>
        <form>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  export default { 
    data() {
      return {
        loginTitle: 'Welcome To movies App',
        loginSubtitle: 'Login to your account'
      }
    }
  }
</script>

<style>
  form {
    border: 0.0625rem solid #000;
    padding: 1.5rem;
    background-color: #f2f2f2;
    border-radius: 0.25rem;
  }

  form label {
    font-weight: 700;
  }

  .login-div {
    position: relative;
    top: 50%;
  }

  .login-header {
    text-align: center;
    padding-bottom: 0.5rem;
  }

  .login-header h2,
  .login-header h5 {
    font-weight: 700;
  }
</style>