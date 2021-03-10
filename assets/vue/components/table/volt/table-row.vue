<!-- Template -->
<template>
  <tr class="volt-table-row" :class="additionalRowClasses" :data-tippy-content="tippyRowBodyContent" ref="tableRow">
    <table-cell v-for="(value, key, index) in rowData" :key="index" :do-show="0 !== value.length && !isKeySkipped(key)">
      <template #cellValue>
        <raw-content :content="value" />
      </template>
    </table-cell>
    <slot></slot>
  </tr>
</template>

<!-- Script -->
<script>
import TableCellComponent   from './table-cell';
import RawContentComponent  from '../../other/raw-content';

import Tippy from '../../../libs/tippy/Tippy';

let tippy = new Tippy();

/**
 * @description tippy js is handled in the DataTables.ts file, as  the logic for tippy MUST be
 *              applied alongside with DataTables
 */
export default {
  data(){
      return {
        tippyInstance: null,
      }
  },
  components: {
    "table-cell": TableCellComponent,
    "raw-content" : RawContentComponent,
  },
  props: {
    "rowData": {
      type     : Object,
      required : true
    },
    "tippyRowBodyContent": {
      type     : String,
      required : false,
      default  : ""
    },
    "skippedKeys": {
      type     : Array,
      required : false,
      default  : [],
    },
    "additionalRowClasses": {
      type     : String,
      required : false,
      default  : {},
    }
  },
  methods: {
    /**
     * @description will check if the provided key in the object/array is skipped
     *              which means that the value for that key won't be shown
     *
     *              Since dto object has properties also beginning with `_`
     *              which in term of TS means that these are private, it's required
     *              to strip the leading underscore
     * @param key
     */
    isKeySkipped(key){
      if( "_" === key.slice(0, 1) ){
        key = key.slice(1, key.length);
      }

      return this.skippedKeys.includes(key);
    },
  },
  mounted(){
    this.tippyInstance = tippy.applyForElement(this.$refs.tableRow);
  },
  updated(){
    if(
            null        !== this.tippyInstance
        &&  "undefined" !== typeof this.tippyInstance
    ){
      this.tippyInstance.setContent(this.tippyRowBodyContent);
    }
  }
}
</script>

<!-- Style -->
<style>
  .volt-table-row {
    border-bottom-color:  rgb(234, 237, 242);
    border-bottom-style:  solid;
    border-bottom-width:  1px;
    border-collapse:  collapse;
    border-left-color:  rgb(234, 237, 242);
    border-left-style:  solid;
    border-left-width:  0;
    border-right-color: rgb(234, 237, 242);
    border-right-style: solid;
    border-right-width: 0;
    border-top-color: rgb(234, 237, 242);
    border-top-style: solid;
    border-top-width: 0;
  }
</style>