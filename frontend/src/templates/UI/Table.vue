<template>
  <div class="layout">
    <a-row justify="space-between" style="margin-bottom: 20px">
      <h2>{{ title }}</h2>
      <a-button type="primary" @click="$emit('create')">Novo</a-button>
    </a-row>
    <a-modal
      v-model:visible="visibleRemove"
      ok-text="Sim"
      cancel-text="Não"
      @ok="deleteItem(true)"
      @cancel="deleteItem(false)"
    >
      <a-row>
        <ExclamationCircleOutlined
          :style="{ fontSize: '20px', margin: '5px', color: '#F2CE46' }"
        />
        <h3>Deseja excluir o item?</h3>
      </a-row>
    </a-modal>
    <a-table bordered :data-source="data" :columns="columns" :loading="loading">
      <template
        #customFilterDropdown="{
          setSelectedKeys,
          selectedKeys,
          clearFilters,
          column,
        }"
      >
        <div style="padding: 8px">
          <a-input
            :placeholder="`Pesquisar ${column.dataIndex}`"
            :value="selectedKeys[0]"
            style="width: 188px; margin-bottom: 8px; display: block"
            @change="
              (e) => setSelectedKeys(e.target.value ? [e.target.value] : [])
            "
            @pressEnter="handleSearch(column.dataIndex, selectedKeys[0])"
          />
          <a-button
            type="primary"
            size="small"
            style="width: 90px; margin-right: 8px"
            @click="handleSearch(column.dataIndex, selectedKeys[0])"
          >
            <template #icon><SearchOutlined /></template>
            Filtrar
          </a-button>
          <a-button
            size="small"
            style="width: 90px"
            @click="handleReset(clearFilters)"
          >
            Limpar
          </a-button>
        </div>
      </template>
      <template #customFilterIcon="{ filtered }">
        <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
      </template>
      <template #bodyCell="{ text, column, record }">
        <span v-if="searchText && searchedColumn === column.dataIndex">
          <template
            v-for="(fragment, i) in text
              .toString()
              .split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))"
          >
            <mark
              v-if="fragment.toLowerCase() === searchText.toLowerCase()"
              :key="i"
              class="highlight"
            >
              {{ fragment }}
            </mark>
            <template v-else>{{ fragment }}</template>
          </template>
        </span>
        <template v-else-if="column.key === 'action'">
          <div style="display: flex; justify-content: space-evenly">
            <span title="Visualizar" v-if="column.onConsult">
              <EyeOutlined
                :style="{ fontSize: '20px' }"
                @click="consult(record)"
              />
            </span>
            <span title="Editar" v-if="column.onEdit">
              <EditOutlined
                :style="{ fontSize: '20px' }"
                @click="edit(record)"
              />
            </span>
            <span title="Excluir" v-if="column.onDelete">
              <DeleteOutlined
                :style="{ fontSize: '20px' }"
                @click="remove(record)"
              />
            </span>
          </div>
        </template>
      </template>
    </a-table>
  </div>
</template>
<script>
import {
  SearchOutlined,
  EyeOutlined,
  EditOutlined,
  DeleteOutlined,
  ExclamationCircleOutlined,
} from "@ant-design/icons-vue";
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    title: {
      type: String,
    },
    id: {
      type: String,
    },
    data: {
      type: Array,
    },
    columns: {
      type: Array,
    },
    loading: {
      type: Boolean,
    },
  },
  data() {
    return {
      visibleRemove: false,
      searchText: "",
      searchedColumn: "",
      search: {},
    };
  },
  components: {
    SearchOutlined,
    EyeOutlined,
    EditOutlined,
    DeleteOutlined,
    ExclamationCircleOutlined,
  },
  methods: {
    handleSearch(dataIndex, value) {
      this.search[dataIndex] = value;
      for (var key in this.search) {
        if (this.search[key] === undefined) {
          delete this.search[key];
        }
      }
      this.$emit("search", this.search);
    },
    handleReset(clearFilters) {
      clearFilters();
      this.searchText = "";
    },
    consult(item) {
      this.$emit("consult", item);
    },
    edit(item) {
      this.$emit("edit", item);
    },
    remove(item) {
      this.itemRemove = item[this.id];
      this.visibleRemove = true;
    },
    deleteItem(confirm) {
      if (confirm) this.$emit("remove", this.itemRemove);
      this.visibleRemove = false;
      this.itemRemove = null;
    },
  },
});
</script>
<style scoped>
.highlight {
  background-color: rgb(255, 192, 105);
  padding: 0px;
}
.layout {
  padding: 10px 40px;
}
</style>
