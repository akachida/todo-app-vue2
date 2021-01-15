<template>
  <div>
    <b-card no-body class="mb-3">
      <b-card-header>
        <h1>To-do List</h1>
        <b-button>
          Cadastrar
        </b-button>
        <b-button>
          Tags
        </b-button>
      </b-card-header>
      <b-card-body>
        <div class="row">
          <div class="col text-center">
            &lt; 13/JAN &gt;
          </div>
        </div>
        <div class="row">
          <div class="col">
            <b-form-input placeholder="Buscar..." />
          </div>
          <div class="col">
            <b-form-checkbox>Finalizadas</b-form-checkbox>
            <b-form-checkbox>Pendentes</b-form-checkbox>
            <b-form-checkbox>Arquivadas</b-form-checkbox>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <b-badge>Total 123456</b-badge>
            <b-badge>Finalizadas 12</b-badge>
            <b-badge>Pendentes 34</b-badge>
            <b-badge>Arquivadas 56</b-badge>
          </div>
        </div>
        <b-list-group>
          <b-list-group-item>
            Item aqui
            <b-badge>tags</b-badge>
            <b-badge>tags</b-badge>
            <b-button>marcar</b-button>
            <b-button>arquivar</b-button>
            <b-button>editar</b-button>
            <b-button>excluir</b-button>
          </b-list-group-item>
          <b-list-group-item>
            Arquivada
            <b-button>desarquivar</b-button>
            <b-button>editar</b-button>
          </b-list-group-item>
        </b-list-group>
      </b-card-body>
    </b-card>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component({})
export default class Todo extends Vue {}
</script>
