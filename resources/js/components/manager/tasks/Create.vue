<template>
  <v-container>
    <v-toolbar color="indigo darken-1" dark>
      <v-toolbar-title>Krok 2. Napisz zadanie</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-card>
      <v-flex sm12 xs12>
        <v-card-text>
          <h5>Wprowadź tytuł zadania</h5>

          <v-form>
            <v-text-field
              counter="150"
              label="Tytuł"
              v-model="form.title"
            ></v-text-field>

            <h5>Opis</h5>

            <markdown-editor :value="form.body" preview-class="markdown-body"
                             v-model="form.body"></markdown-editor>

            <flash-box :success="flashSuccess" :text="flashText" v-if="flashShow"></flash-box>

            <v-layout align-end fill-height justify-end row>
              <v-btn
                @click="clear"
                color="grey"
                dark
                text-xs-end
              >Wyczyść
              </v-btn>

              <v-spacer></v-spacer>

              <v-btn
                @click="send"
                color="primary"
                dark
                large
                text-xs-end
              >Wyślij
              </v-btn>
            </v-layout>

          </v-form>
        </v-card-text>
      </v-flex>
    </v-card>
  </v-container>
</template>

<script>
  import FlashBox from '../../helpers/FlashBox';

  export default {
    components: {FlashBox},
    data() {
      return {
        form: {
          'body': null,
          'title': null,
        },
        flashSuccess: false,
        flashText: 'Nieznany błąd!',
        flashShow: false,
      }
    },
    created() {
      this.listen();
    },
    methods: {
      send() {
        if (!this.form.title) {
          EventBus.$emit('showCreateNewTaskError', 'Wprowadź tytuł zadania');
          return;
        }

        if (this.form.title.length > 150) {
          EventBus.$emit('showCreateNewTaskError', 'Tytuł może mieć maksymalnie 150 znaków');
          return;
        }

        if (this.form.title.length < 4) {
          EventBus.$emit('showCreateNewTaskError', 'Tytuł zadania musi składać się z minimum 3 znaków');
          return;
        }

        EventBus.$emit('sendTask', this.form);
      },
      clear() {
        this.form.body = '';
        this.form.title = '';
      },
      listen() {
        EventBus.$on('showCreateNewTaskSuccess', () => {
          this.form.title = null;
        });
        EventBus.$on('showCreateNewTaskError', (text) => {
          this.flashShow = false;
          this.flashSuccess = false;
          this.flashText = text;
          this.flashShow = true;
        });
        EventBus.$on('showCreateNewTaskSuccess', (text) => {
          this.flashShow = false;
          this.flashSuccess = true;
          this.flashText = text;
          this.flashShow = true;
        });
      },
    },
  }
</script>
