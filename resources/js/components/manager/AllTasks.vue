<template>
  <div>
    <show-all-tasks></show-all-tasks>
  </div>
</template>

<script>
  import ShowAllTasks from './tasks/index'

  export default {
    components: {ShowAllTasks},
    created() {
      User.logoutIfTokenExp();
      if (User.isWorker()) {
        this.$router.push({name: 'my-tasks'});
      } else if (!User.isLogged()) {
        this.$router.push({name: 'home'});
      }
    },
  }
</script>
