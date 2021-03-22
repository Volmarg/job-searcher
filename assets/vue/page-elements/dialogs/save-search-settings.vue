<script type="ts">
import PreconfiguredVue from "../../PreconfiguredVue";

/**
 * @description this is required as the dialog contains the emit event and it must be emitted via vue thus instance is required
 */
PreconfiguredVue.createApp("#saveSearchSettingsDialog", {});

export default{};
</script>