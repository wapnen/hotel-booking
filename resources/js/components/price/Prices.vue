<template>
<div class="wrapper">
<sidebar title = "Prices"></sidebar>
  <div class="main-panel">
    <!-- Navbar -->
    <navigation title = "Prices"></navigation>
    <!-- End Navbar -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Prices | <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#priceModal" @click= "createPrice()">Add price</button> </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                        Price
                      </th>
                      <th>
                        currency
                      </th>
                      <th>
                        Room type
                      </th>

                      <th class="text-center">
                        Edit
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="price in prices">
                      <td>
                        {{price.price}}
                      </td>
                      <td>
                        {{price.currency}}
                      </td>
                      <td>
                        {{getRoomType(Number(price.room_type_id))}}
                      </td>
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" name="button" data-toggle="modal" data-target="#priceModal"
                        @click=" editPrice(price)" > <i class="fa fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#editPriceModal"
                        @click=" deletePrice(price.id)" > <i class="fa fa-trash"></i> </button>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
      <footer-nav></footer-nav>
      <!-- price modal -->
      <div class="modal fade " id="priceModal" tabindex="-1" role="dialog" aria-labelledby="Price" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'edit'">Edit Price</h5>
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'create'">Create Price</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="price.id">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Price (USD)</label>
                          <input type="number" step="0.01" class="form-control"  placeholder="0.00" v-model = "price.price" required>
                        </div>
                      </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Room type</label>
                            <select class="form-control" name="room_type_id" v-model="price.room_type_id" required>
                              <option :value="this.price.room_type_id" v-show="this.form_mode == 'edit'"> {{roomTypeName}}</option>
                              <option v-for="roomType in roomTypes" :value="roomType.id">{{roomType.name}}</option>

                            </select>
                          </div>
                        </div>
                    </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  class="btn btn-primary" @click="updatePrice()" v-show="this.form_mode == 'edit'">Save changes</button>
              <button type="button"  class="btn btn-primary" @click="savePrice()" v-show="this.form_mode == 'create'">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end price modal  -->
  </div>
</div>
</template>
<script>
import axios from 'axios'
export default {
  data(){
    return {
        prices : [],
        roomTypes: [],
        price: {},
        form_mode: "create",
        roomTypeName: ""

    }
  },
  mounted: function mounted() {
    this.getPrices()
    this.getRoomTypes()
  },
  methods: {
    getPrices: function getPrices() {
      var _this = this;

      axios.get('/api/prices').then(function (response) {
        _this.prices = response.data;

      });
    },
    createPrice: function createPrice(){
      this.form_mode = "create"
    },
    savePrice: function savePrice(){
      axios.post('/api/prices', this.price).then(response => {
        this.notify("Saved" , "success")
        this.resetForm()
      });
    },
    editPrice: function editPrice(price){
      this.form_mode = "edit"
      this.price = price;
      this.roomTypeName = this.getRoomType(Number(price.room_type_id))
    },
    updatePrice: function updatePrice(){
      axios.put(`api/prices/${this.price.id}`, this.price).then(response => {

            //notify user
            this.notify("Changes saved", "success")
            this.resetForm()
        })
    },
    deletePrice: function deletePrice(price){
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          axios.delete(`/api/prices/${price}`).then(response => {
            this.getPrices()
            this.notify("Price deleted", "danger")
          });
        }
      })

    },
    getRoomTypes: function getRoomTypes() {
      var _this = this;

      axios.get('/api/roomtypes').then(function (response) {

        _this.roomTypes = response.data;

      });
    },
    getRoomType: function getRoomType(id){
      const roomTypes = this.roomTypes
      let result = roomTypes.find((obj) =>  obj.id === id)
      return result.name
    },
    notify : function notify(message, type){
      //notify user
      $.notify({
        // options
        message: message
      },{
        // settings
        type: type
      });
    },
    resetForm: function resetForm(){

      //close modal
      $('#priceModal').modal('hide')
      this.getPrices()
      this.price = {}

    },
  },
  beforeRouteEnter (to, from, next) {
      let token = localStorage.getItem('jwt')

      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

      axios.post('/api/auth/me').then(response => {
      }).catch(error =>{
        if(error.response.status == 401){
          console.log(error.response.status)
          return next('login')
        }
      })
      next()

    }
}
</script>
