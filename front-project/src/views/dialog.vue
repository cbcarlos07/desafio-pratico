<template>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="290"
    >
        <v-card>
            <v-card-title class="text-h5">
                Atenção
            </v-card-title>
            <v-card-text v-html="title"></v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="red"
                    text
                    @click="$emit('fechar')"
                >
                    <v-icon small>fa-remove </v-icon>
                    &nbsp;
                    Não
                </v-btn>
                <v-btn
                    color="green darken-1"
                    text
                    @click="$emit('confirmar')"
                >
                    <v-icon small>fa-check-square </v-icon>
                    &nbsp;
                    Sim
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: ['dialog', 'title']
}
</script>