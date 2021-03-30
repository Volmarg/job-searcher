<!-- Template -->
<template>
  <tr ref="searchSettingRow_{{ settingId }}" class="">
    <td class="clickable-cell"
        @click="removeCallback(settingId)"
    >
      <i class="feather icon-trash-2"></i>
    </td>
    <td class="clickable-cell"
        @click="loadCallback(settingId)"
    >
      <i class="feather icon-download-cloud"></i>
    </td>
    <td class="name">{{ settingName }}</td>
  </tr>
</template>

<!-- Script -->
<script type="ts">
export default {
  props: {
    settingId: {
      type     : Number,
      required : true
    },
    settingName: {
      type     : String,
      required : true
    },
    removeCallback: {
      type     : Function,
      required : true,
    },
    loadCallback: {
      type     : Function,
      required : true,
    }
  },
  mounted() {
    console.log('mounted');
  }
}
</script>