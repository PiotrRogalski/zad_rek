<template>
  <div>
    <select-user></select-user>
    <create-task></create-task>
  </div>
</template>

<script>
  import CreateTask from './tasks/Create';
  import SelectUser from './users/Show';

  export default {
    components: {CreateTask, SelectUser},
    created() {
      // TODO: pull up to make more it generic.
      User.logoutIfTokenExp();

      if (User.isWorker()) {
        this.$router.push({name: 'my-tasks'});
      } else if (!User.isLogged()) {
        this.$router.push({name: 'home'});
      }
    },
  }
</script>
