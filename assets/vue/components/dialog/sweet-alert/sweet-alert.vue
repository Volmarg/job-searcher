<!-- Template -->
<template>
  <div class="swal2-container swal2-center swal2-backdrop-show dialog-container d-none" :id="id">
    <div aria-labelledby="swal2-title" aria-describedby="swal2-content"
         class="swal2-popup swal2-modal swal2-icon-warning swal2-show d-flex" tabindex="-1" role="dialog" aria-live="assertive"
         aria-modal="true">
      <div class="swal2-header">
        <h2 class="swal2-title d-flex" id="swal2-title">
          {{ headerString }}
        </h2>
        <button type="button" class="swal2-close d-block" @click="closeDialog()">×</button>
      </div>
      <div class="swal2-content mt-3">
        <div id="swal2-content" class="swal2-html-container d-block">
          <slot name="body-content"></slot>
        </div>
      </div>
      <div class="swal2-actions">
        <div class="swal2-loader"></div>
        <button type="button" class="btn btn-success" @click.prevent="$emit('confirmButtonClicked')">
          {{ confirmButtonString }}
        </button>
        <button type="button" class="btn btn-danger ml-3" @click="closeDialog()">
          {{ cancelButtonString }}
        </button>
      </div>
    </div>
  </div>
</template>

<!-- Script !-->
<script type="ts">
import PreconfiguredVue from "../../../PreconfiguredVue";
import SweetAlert       from "../../../../js/libs/sweetalert/SweetAlert";

export default {
  emits: [
    'confirmButtonClicked',
  ],
  props: {
    confirmButtonString: {
      type     : String,
      required : true
    },
    cancelButtonString: {
      type     : String,
      required : true,
    },
    headerString: {
      type     : String,
      required : false,
      default : "test"
    },
    id: {
      type     : String,
      required : true
    }
  },
  methods: {
    closeDialog(){
      SweetAlert.hideDialogForId(this.id);
    },
    showDialog(){
      SweetAlert.showDialogForId(this.id);
    }
  }
};
</script>

<!-- Style -->
<style scoped>
  .confirm-button {
    display: inline-block;
    background-color: rgb(48, 133, 214);
  }

  .cancel-button {
    display: inline-block;
    background-color: rgb(221, 51, 51);
  }

  .dialog-container {
    overflow-y: auto;
  }
</style>