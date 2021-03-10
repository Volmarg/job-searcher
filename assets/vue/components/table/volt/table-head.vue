<!-- Template -->
<template>
  <thead class="thead-light">
  <tr>
    <th v-for="(header, index) in tableHeaders" :key="index" class="border-0">{{ header }}</th>
  </tr>
  </thead>
</template>

<!-- Script -->
<script>
export default {
  props: {
    "tableHeaders": {
      type     : Array,
      required : true
    }
  }
}
</script>