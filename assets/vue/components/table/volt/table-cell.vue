<!-- Template -->
<template>
  <td class="border-0" v-if="doShow">
    <slot name="cellValue"></slot>
  </td>
</template>

<!-- Script -->
<script>
export default {
  props: {
    doShow: {
      type    : Boolean,
      default : true,
    }
  }
}
</script>