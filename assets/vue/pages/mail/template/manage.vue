<script lang="ts">
import PreconfiguredVue  from "../../../PreconfiguredVue";

PreconfiguredVue.createApp('#mail-template-manage', {
  data(){
  },
  methods: {
    testLog(){
      console.log("test");
    }
  },
  mounted(){
    console.log(this.$refs.saveTemplateButton);
  }
})

export default{}
</script>