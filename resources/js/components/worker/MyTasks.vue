<template>
  <div>
    <show-tasks></show-tasks>
  </div>
</template>

<script>
  import ShowTasks from './tasks/Index'

  export default {
    components: {ShowTasks},
    data() {
      return {
        isLoading: true,
      };
    },
    created() {
      User.logoutIfTokenExp();
      if (User.isManager()) {
        this.$router.push({name: 'home'});
      } else if (!User.isLogged()) {
        this.$router.push({name: 'home'});
      }
    },
  }
</script>
