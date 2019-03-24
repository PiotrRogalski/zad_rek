<template>
  <v-container>
    <v-toolbar color="teal darken-1" dark>
      <v-toolbar-title>{{myTasksTitle}}</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-card>
      <v-flex sm12 xs12>
        <v-card-title>
          <v-spacer></v-spacer>
          <v-text-field
            append-icon="search"
            hide-details
            label="Szukaj"
            single-line
            v-model="search"
          ></v-text-field>
        </v-card-title>
        <v-card-text>

          <div>
            <v-data-table
              :expand="expand"
              :headers="headers"
              :items="tasks"
              :loading="isLoading"
              :pagination.sync="pagination"
              :search="search"
              class="elevation-1"
              item-key="id"
            >
              <template v-slot:items="props">
                <tr :class="(tasks[props.index].accepted_at) ? colorOk : ''"
                    @click="props.expanded = !props.expanded">
                  <td>{{ props.item.id }}</td>
                  <td><b>{{ props.item.title }}</b></td>
                  <td class="text-xs-right">
                    {{ formatDate(props.item.updated_at.date) }}
                  </td>
                  <td class="text-xs-right">{{ tasks[props.index].accepted_at }}
                    <v-icon
                      color="green"
                      v-if="tasks[props.index].accepted_at"
                    >done
                    </v-icon>
                  </td>
                </tr>
              </template>

              <template v-slot:expand="props">
                <v-card flat>
                  <v-card-title><b>Opis</b></v-card-title>

                  <v-card-text>{{ props.item.body }}</v-card-text>

                  <v-card-actions v-if="tasks[props.index].accepted_at == null">
                    <v-spacer></v-spacer>
                    <v-btn @click="acceptTask(props.item.id, props.index)" color="success" dark
                           small
                    >Zatwierdź
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </template>

            </v-data-table>
          </div>

        </v-card-text>
      </v-flex>
    </v-card>
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        myTasksTitle: 'Moje zadania',
        colorOk: 'green--text text--darken-1',
        isLoading: true,
        tasks: [],
        userAcceptedTasks: [],
        search: '',
        pagination: {'sortBy': 'id', 'descending': true},
        selected: [],
        expand: false,
        headers: [
          {
            text: 'Nr',
            align: 'left',
            value: 'id'
          },
          {text: 'Nazwa zadania', value: 'title'},
          {text: 'Nadano', sortable: false, value: 'updated_at'},
          {
            text: 'Zatwierdzono',
            sortable: false,
            value: 'accepted_at'
          },
        ],

      }
    },
    created() {
      this.getTasks();
    },
    computed: {
      pages() {
        if (this.pagination.rowsPerPage == null || this.pagination.totalItems == null) {
          return 0;
        }

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      },
    },
    methods: {
      getTasks() {
        axios.get('/api/task-user')
          .then(res => {
            this.addTask(res);
            this.isLoading = false;
          })
          .catch(() => console.log('Błąd połączenia z bazą danych'))
      },
      acceptTask(task_id, index) {
        axios.patch(`/api/task-user/${task_id}`)
          .then(res => this.tasks[index].accepted_at = res.data)
          .catch(() => console.log('Nie można zatwierdzić zadania'))
      },
      addTask(res) {
        this.tasks = res.data.data;
        if (this.tasks.length > 0) {
          this.myTasksTitle = 'Moje zadania';
        } else {
          this.myTasksTitle = 'Nie ma jeszcze żadnych zadań';
        }
      },
      formatDate(datetime) {
        let date = new Date(Date.parse(datetime));
        let Y = date.getFullYear();
        let M = date.getMonth() + 1;
        let D = date.getDate();
        let h = date.getHours();
        let m = date.getMinutes();
        let s = date.getSeconds();

        if (M < 10) {
          M = '0' + M
        }
        if (s < 10) {
          s = '0' + s
        }

        return `${Y}-${M}-${D} ${h}:${m}:${s}`;
      },
    },
  }
</script>
