<template>
  <div>
  <div class="panel-heading">All users</div>
  <table class="table table-bordered table-striped">
    <thead>
    <tr>
      <th class="col-sm-4">Name</th>
      <th class="col-sm-4">Email</th>
      <th class="col-sm-2">Invitation</th>
    </tr>
    </thead>
    <tbody>

    <tr>
    <tr v-for="user in users">
      <td>{{ user.name }}</td>
      <td>{{ user.email }}</td>
      <b-button block type="submit" variant="outline-primary">invite</b-button
      >
    </tr>
    </tbody>
  </table>
  </div>
</template>

<style scoped></style>
<script>


import axios from "axios";
import {mapActions} from "vuex";

export default {
  name: "Friends",
  methods: {
    ...mapActions({
      listOfFriends: "auth/listFriends",
    }),
    submit() {
      this.listFriends(this.$data).then(() => {
        console.log("finished");
      });
    },
  }
  };
</script>