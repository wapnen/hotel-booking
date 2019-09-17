<template>
<div class="sidebar">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
-->
  <div class="sidebar-wrapper">
    <div class="logo">
      <a href="javascript:void(0)" class="simple-text logo-mini">
        HM
      </a>
      <a href="javascript:void(0)" class="simple-text logo-normal">
        Hotel Manager
      </a>
    </div>
    <ul class="nav">
      <li v-bind:class="{ active : isActive('Bookings')}">
        <router-link :to="{ name: 'bookings' }">
          <i class="tim-icons icon-bullet-list-67"></i>
        <p>Bookings</p>
      </router-link>
      </li>
      <li v-bind:class="{ active : isActive('Hotels')}">
        <router-link :to="{ name: 'hotels' }">
          <i class="tim-icons icon-bank"></i>
        <p>Hotels</p>
      </router-link>
      </li>
      <li v-bind:class="{ active : isActive('Room type')}">
        <router-link :to="{ name: 'roomTypes' }">
          <i class="tim-icons icon-components"></i>
        <p>Room types</p>
      </router-link>
      </li>
      <li v-bind:class="{ active : isActive('Prices')}">
        <router-link :to="{ name: 'prices' }">
          <i class="tim-icons icon-money-coins"></i>
        <p>Price list</p>
      </router-link>
      </li>



    </ul>
  </div>
</div>

</template>
<script>
  export default {
    props : ['title'],
    methods : {
      isActive : function isActive(value){
        return this.title == value ? true : false
      }
    }
  }
</script>
