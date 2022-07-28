<template>
  <ul class="list-unstyled">
    <li class="" v-for="item in items">
      <div class="checkbox-area">
        <Checkbox :id="'el-' + item[valueField]"
                  :value="item"
                  :display-field="displayField"
                  :value-field="valueField"
        >
        </Checkbox>
        <TreeList v-if="item.children !== undefined && item.children.length > 0"
                  :items="item.children"
                  :display-field="displayField"
                  :value-field="valueField"
        >
        </TreeList>
      </div>
    </li>
  </ul>
</template>

<script>
import Checkbox from "./Checkbox";

export default {
  name: "TreeList",
  components: {
    Checkbox
  },
  props: {
    items: {
      type: Array
    },
    displayField: {
      type: String,
      required: true
    },
    valueField: {
      type: String,
      required: true
    }
  },
}
</script>