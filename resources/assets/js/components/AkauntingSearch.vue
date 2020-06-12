<template>
  <el-select
    :class="'pl-20 mr-40'"
    v-model="value"
    filterable
    remote
    reserve-keyword
    placeholder="Buscar"
    :remote-method="remoteMethod"
    :loading="loading"
  >
    <div v-if="results.length == 0" slot="empty">
      <p class="el-select-dropdown__empty">Sem resultados...</p>
    </div>
    <a :href="'/common/items/'+ item.id +'/edit'" v-for="item in results" :key="item.id">
      <el-option :label="item.name" :value="item.name">
        <span style="color: #8492a6; font-size: 13px">{{ item.name }}</span>
      </el-option>
    </a>
  </el-select>
</template>

<style>
.el-select {
  display: inline;
}
</style>

<script>
import { Select, Option, OptionGroup } from "element-ui";

export default {
  name: "akaunting-select",

  components: {
    [Select.name]: Select,
    [Option.name]: Option,
    [OptionGroup.name]: OptionGroup
  },

  data() {
    return {
      //   query: null,
      results: [],
      value: [],
      list: [],
      loading: false
    };
  },
  //   watch: {
  //     query(after, before) {
  //       this.search();
  //     }
  //   },
  methods: {
    remoteMethod(query) {
      console.log(query);
      if (query !== "") {
        axios
          .get("/common/search-item/search", { params: { query: query } })
          .then(response => (this.results = response.data))
          .catch(error => {});
      } else {
        this.results = [];
      }
    }
  }
};
</script>
