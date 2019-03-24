<template>
  <v-container>
    <v-flex sm12 xs12>
      <v-alert :value="alert"
               transition="scale-transition"
               type="error"
               v-if="!success"
      >
        {{ this.text }}
      </v-alert>

      <v-alert :value="alert"
               transition="scale-transition"
               type="success"
               v-if="success"
      >
        {{ this.text }}
      </v-alert>
    </v-flex>
  </v-container>
</template>

<script>
  export default {
    props: ['text', 'success'],
    data() {
      return {
        alert: true
      };
    },
  }
</script>
