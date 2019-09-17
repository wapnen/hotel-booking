<template>
<div class="wrapper">
<sidebar title = "Hotels"></sidebar>
  <div class="main-panel">
    <!-- Navbar -->
    <navigation title = "Hotels"></navigation>
    <!-- End Navbar -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Hotels</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                        Name
                      </th>
                      <th>
                        Address
                      </th>
                      <th>
                        Email
                      </th>
                      <th class="text-center">
                        Phone
                      </th>
                      <th class="text-center">
                        Edit
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="hotel in hotels">
                      <td>
                        {{hotel.name}}
                      </td>
                      <td>
                        {{hotel.city}} , {{hotel.state}}, {{hotel.country}}
                      </td>
                      <td>
                        {{hotel.email}}
                      </td>
                      <td class="text-center">
                        {{hotel.phone}}
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning" name="button" data-toggle="modal" data-target="#editHotelModal"
                        @click=" editHotel(hotel.id, hotel.name, hotel.address, hotel.city, hotel.state, hotel.country, hotel.zip, hotel.phone, hotel.email)" >Edit</button>
                      </td>
                      <td>
                        <router-link :to="{name : 'hotel', params : {hotel_id : hotel.id}}" class="btn btn-primary">
                          View
                        </router-link>
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
      <!-- edit hotel modal -->
      <div class="modal fade editHotel" id="editHotelModal" tabindex="-1" role="dialog" aria-labelledby="EditHotel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Edit hotel</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="id">
                <div class="row">
                  <div class="col-md-5 pr-md-1">
                    <div class="form-group">
                      <label>Hotel name</label>
                      <input type="text" class="form-control"  placeholder="Hotel name" v-model = "name" required>
                    </div>
                  </div>
                  <div class="col-md-3 px-md-1">
                    <div class="form-group">
                      <label>Hotel phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="08023213223" v-model="phone" required>
                    </div>
                  </div>
                  <div class="col-md-4 pl-md-1">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" placeholder="hotel@email.com" id="email" name="email" v-model="email" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" class="form-control" placeholder="Hotel Address" id="address" name="address" v-model = "address" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4 pr-md-1">
                    <div class="form-group">
                      <label>City</label>
                      <input type="text" class="form-control" placeholder="City" id="city" name="city" v-model = "city">
                    </div>
                  </div>
                  <div class="col-md-4 px-md-1">
                    <div class="form-group">
                      <label>Country</label>
                      <input type="text" class="form-control" placeholder="Country" v-model="country" id="country" name="country">
                    </div>
                  </div>
                  <div class="col-md-4 pl-md-1">
                    <div class="form-group">
                      <label>Postal Code</label>
                      <input type="text" class="form-control" placeholder="ZIP Code" id="zip" name="zip" v-model="zip">
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  class="btn btn-primary" @click="updateHotel()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end edit hotel modal  -->
  </div>
</div>
</template>
<script>
import axios from 'axios'
export default {
  data(){
    return {
        hotels : [],
        id : '',
        name : '',
        address : '',
        city : '',
        state : '',
        country : '',
        zip : '',
        phone : '',
        email : '',
    }
  },
  mounted: function mounted() {
    this.getHotels();
  },
  methods: {
    getHotels: function getHotels() {
      var _this = this;

      axios.get('/api/hotels').then(function (response) {
        _this.hotels = response.data;

      });
    },
    editHotel: function editHotel(id, name, address, city, state, country, zip, phone, email){
      this.id = id;
      this.name = name;
      this.address = address;
      this.city = city;
      this.state = state;
      this.country = country;
      this.zip = zip;
      this.phone = phone;
      this.email = email;
    },
    updateHotel: function updateHotel(){
      axios.put(`api/hotels/${this.id}`, {name: this.name, address: this.address, city: this.city, state: this.state, country: this.country, zip : this.zip, phone : this.phone, email : this.email}).then(response => {
            console.log(response.data)
            //update the table
            this.getHotels();
            //close modal
            $('#editHotelModal').modal('hide')
            //notify user
            $.notify({
            	// options
            	message: 'Changes saved'
            },{
            	// settings
            	type: 'success'
            });
        })
    }
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
