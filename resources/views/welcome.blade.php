<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://unpkg.com/vue-request"></script>

    <title>Проверка ИНН</title>

    <style>
      body {
          max-width: 1280px;
          margin: 50px auto;
      }
</style>
  </head>
  <body>
    <h1>Проверка ИНН</h1>
    <div id="counter">
<div class="input-group mb-3">
  <span class="input-group-text">ИНН физического лица</span>
  <input type="text" class="form-control" v-model="input">
  
    <button v-on:click="check" class="btn btn-info">проверить</button>
</div>
 <p class="small text-danger" v-if="check_data.error">@{{check_data.error}}</p>
 <p class="small text-success" v-if="check_data.success" >@{{check_data.success}}</p>
    </div>

  </body>
       <script>
         const panel = {
             data() {
                 return {
                   input:'',
                   check_data:{}
                 }
             },
             methods: {
               check() {
                   this.check_data = window.VueRequest.useRequest({
                         url: 'api/inn_check',
                         method: 'POST',
                         body: JSON.stringify(this.input),
                         headers: new Headers({
                             'Content-Type': 'application/json',
                         }),
                     }).data;
                 }
             }
         }
         Vue.createApp(panel).mount('#counter')
       </script>
</html> 
