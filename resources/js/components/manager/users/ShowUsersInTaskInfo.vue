<template>
  <div>
    <v-card-title>
      Osoby, które otrzymały to zadanie
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        hide-details
        label="Szukaj"
        single-line
        v-model="search"
      ></v-text-field>
    </v-card-title>

    <v-data-table
      :headers="headers"
      :items="users"
      :pagination.sync="pagination"
      :search="search"
      class="elevation-1"
      item-key="name"
    >
      <template v-slot:headers="props">
        <tr>
          <th
            :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
            :key="header.text"
            @click="changeSort(header.value)"
            v-for="header in props.headers"
          >
            <v-icon small>arrow_upward</v-icon>
            {{ header.text }}
          </th>
        </tr>
      </template>
      <template v-slot:items="props">
        <tr>
          <td>
            {{ (props.item.name == null) ? 'Nazwisko: ' : props.item.name + ' ' }}
            {{ (props.item.surname == null) ? '' : props.item.surname }}
          </td>
          <td class="text-xs-right">
            {{ (props.item.email == null) ? 'Brak' : props.item.email}}
          </td>
          <td class="text-xs-right">
            {{ (props.item.pivot.accepted_at == null) ? 'Nie zatwierdził/a' :
            props.item.pivot.accepted_at}}
          </td>
        </tr>
      </template>
    </v-data-table>
  </div>
</template>

<script>
  export default {
    props: ['users'],
    data: () => ({
      search: '',
      form: {},
      pagination: {
        sortBy: 'name'
      },
      headers: [
        {
          text: 'Imię i nazwisko',
          align: 'left',
          value: 'name'
        },
        {text: 'E-mail', align: 'right', value: 'email'},
        {text: 'Data zatwierdzenia', align: 'right', value: 'pivot.accepted_at'},
      ],
    }),
    methods: {
      changeSort(column) {
        if (this.pagination.sortBy === column) {
          this.pagination.descending = !this.pagination.descending;
        } else {
          this.pagination.sortBy = column;
          this.pagination.descending = false;
        }
      }
    }
  }
</script>
