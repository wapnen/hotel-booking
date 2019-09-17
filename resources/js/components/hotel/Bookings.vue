<template>
<div class="wrapper">
<sidebar title = "Bookings"></sidebar>
  <div class="main-panel">
    <!-- Navbar -->
    <navigation title = "Bookings"></navigation>
    <!-- End Navbar -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class='calendar'>

                <FullCalendar
                  class='demo-app-calendar'
                  ref="fullCalendar"
                  defaultView="dayGridMonth"
                  :header="{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                  }"
                  :plugins="calendarPlugins"
                  :weekends="calendarWeekends"
                  :events="bookings"
                  />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">

          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Bookings | <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#bookingModal" @click= "createBooking()">Make a reservation</button> </h4>
            </div>
            <div class="card-body">

              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                        Customer name
                      </th>
                      <th>
                        Customer email
                      </th>
                      <th>
                        Room
                      </th>
                      <th>
                        Total nights
                      </th>
                      <th>Total price (USD)</th>
                      <th class="text-center">
                        Edit
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="booking in bookings">
                      <td>
                        {{booking.customer_name}}
                      </td>
                      <td>
                        {{booking.customer_email}}
                      </td>

                      <td>
                        {{getRoom(Number(booking.room_id))}}
                      </td>
                      <td>
                        {{booking.total_nights}}
                      </td>
                      <td>
                        ${{booking.total_price}}
                      </td>
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" name="button" data-toggle="modal" data-target="#bookingModal"
                        @click=" editBooking(booking)" > <i class="fa fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#editBookingModal"
                        @click=" deleteBooking(booking.id)" > <i class="fa fa-trash"></i> </button>
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
      <!-- booking modal -->
      <div class="modal fade " id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="Booking" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'edit'">Edit Booking</h5>
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'create'">Make a reservation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="booking.id">

                    <div class="row">

                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Room</label>
                            <select class="form-control" name="room_type_id" v-model="booking.room_id" required>

                              <option v-for="room in rooms" :value="room.id">{{room.name}}</option>

                            </select>
                          </div>
                        </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Customer name</label>
                          <input type="text" class="form-control"  placeholder="John Doe" v-model = "booking.customer_name" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Customer email</label>
                          <input type="email" class="form-control"  placeholder="John@email.com" v-model = "booking.customer_email" required>
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Check in date</label>
                          <input type="date" class="form-control"  placeholder="dd/mm/yyyy" v-model = "booking.start" v-bind:class="{'is-invalid': hasError('start') }" required>
                          <span class="invalid-feedback" role="alert">
                            <strong v-for = "error in errors.start">{{ error }} </strong>
                          </span>
                        </div>

                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Check out date </label>
                          <input type="date" class="form-control"   placeholder="dd/mm/yyyy" v-model = "booking.end"   v-bind:class="{'is-invalid': hasError('end') }" required>
                          <span class="invalid-feedback" role="alert">
                              <strong v-for = "error in errors.end">{{ error }} </strong>
                          </span>
                        </div>
                      </div>

                    </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  class="btn btn-primary" @click="updateBooking()" v-show="this.form_mode == 'edit'">Save changes</button>
              <button type="button"  class="btn btn-primary" @click="saveBooking()" v-show="this.form_mode == 'create'">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end booking modal  -->
  </div>
</div>
</template>
<script>
import axios from 'axios'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data(){
    return {
        bookings : [],
        rooms: [],
        booking: {},
        form_mode: "create",
        roomTypeName: "",
        errors : {},
        calendarPlugins: [ // plugins must be defined in the JS
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin // needed for dateClick
      ],
      calendarWeekends: true,
      calendarEvents: [ // initial event data
        { title: 'Event Now', start: new Date() }
      ]

    }
  },
  mounted: function mounted() {

    this.getBookings()
    this.getRooms()

  },
  methods: {
    getBookings: function getBookings() {
      var _this = this;

      axios.get('/api/bookings').then(function (response) {
        _this.bookings = response.data;
        var Bookings =  _this.bookings
        Bookings.forEach(function(booking){

          booking.title = booking.customer_name
        })


      });
    },
    createBooking: function createBooking(){
      this.form_mode = "create"
    },
    saveBooking: function saveBooking(){
      axios.post('/api/bookings', this.booking).then(response => {

        if(response.data.errors){
          this.errors = response.data.errors
          }
        else{
          this.notify("Saved" , "success")
          this.resetForm()
        }


      });
    },
    editBooking: function editBooking(booking){
      this.form_mode = "edit"
      this.booking = booking;
      this.roomTypeName = this.getRoomType(Number(booking.room_type_id))
    },
    updateBooking: function updateBooking(){
      axios.put(`api/bookings/${this.booking.id}`, this.booking).then(response => {
        if(response.data.errors){
          this.errors = response.data.errors
        }
        else{
          //notify user
          this.notify("Changes saved", "success")
          this.resetForm()
        }

        })
    },
    deleteBooking: function deleteBooking(booking){
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
          axios.delete(`/api/bookings/${booking}`).then(response => {
            this.getBookings()
            this.notify("Booking deleted", "danger")
          });
        }
      })

    },
    getRooms: function getRooms() {
      var _this = this;

      axios.get('/api/rooms').then(function (response) {

        _this.rooms = response.data;
      });
    },
    getRoom: function getRoom(id){
      const rooms = this.rooms
      let result = rooms.find((obj) =>  obj.id === id)
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
      $('#bookingModal').modal('hide')
      this.getBookings()
      this.booking = {}

    },
    hasError: function hasError(input){
      return this.errors.hasOwnProperty(input)
    },
    handleEventClick(arg){
      //alert(arg.dateStr)
    }
  },
  beforeRouteEnter (to, from, next) {
      let token = localStorage.getItem('jwt')

      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

      axios.post('/api/auth/me').then(response => {
      }).catch(error =>{
        if(error.response.status == 401){
          return next('login')
        }
      })
      next()

    }
}
</script>
