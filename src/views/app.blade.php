<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
  <div id="app">
    <v-app>
      <v-content>
        <v-container>
            <v-layout row wrap>
                <v-flex offset-lg2 lg8 offset-md2 md8 offset-sm2 sm8>
                    <v-card>
                        <v-card-title primary-title>
                            <v-flex xs12>
                                <v-text-field
                                v-model="name"
                                solo
                                label="Name"
                                clearable
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12 v-for="(col, index) in cols" :key="index">
                                <v-layout row wrap>
                                    <v-flex xs4 md4>
                                        <v-layout row wrap>
                                            <v-flex xs4 md4>
                                                <v-btn @click="deleteCol(index)" 
                                                flat icon color="pink">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </v-flex>
                                            <v-flex xs8>
                                                <v-combobox
                                                    v-model="col.type"
                                                    solo
                                                    :items="items"
                                                    label="Data Type"
                                                ></v-combobox>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex> 
                                    <v-flex xs8 md8>
                                        <v-layout row wrap>
                                            <v-flex xs8 md8>
                                                <v-text-field
                                                v-model="col.name"
                                                solo
                                                label="Name"
                                                clearable
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs4 md4>
                                                <v-switch
                                                right
                                                class="mb-1 ml-2"
                                                v-model="col.nullable"
                                                ></v-switch>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>                    
                            </v-flex>

                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn @click="add_col" flat fab dark small color="orange">
                                <v-icon dark>add</v-icon>
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn dark @click="migrate(0)" color="orange"
                                @click="migrate(1)" 
                                color="orange" 
                                :disabled="loading_dialog.show"
                                :loading="loading_dialog.show"
                            >Migrate</v-btn>
                            <v-btn dark 
                                @click="migrate(1)" 
                                color="orange" 
                                :disabled="loading_dialog.show"
                                :loading="loading_dialog.show"
                            >Migrate + Model</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>

        {{-- Loading dialog --}}
        <div class="text-xs-center">
            <v-dialog
              v-model="loading_dialog.show"
              hide-overlay
              persistent
              width="300"
            >
              <v-card
                color="primary"
                dark
              >
                <v-card-text>
                  @{{ loading_dialog.text }}
                  <v-progress-linear
                    indeterminate
                    color="white"
                    class="mb-0"
                  ></v-progress-linear>
                </v-card-text>
              </v-card>
            </v-dialog>
          </div>

          {{-- Success/Error dialog --}}
          <div class="text-xs-center">
            <v-dialog
              v-model="result_dialog.show"
              hide-overlay
              width="300"
            >
              <v-card
                :color="result_dialog.color"
                dark
              >
                <v-card-text>
                  @{{ result_dialog.text }}
                </v-card-text>
              </v-card>
            </v-dialog>
          </div>

      </v-content>
    </v-app>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
  <script>
    new Vue({ 
        el: '#app',
        data: {
            name: "",
            items: ["string", "text", "integer", "boolean", "float"],
            cols: [{type:"",name:"",nullable:false}],
            loading_dialog: {show:false,text:""},
            result_dialog: {show:false,text:"",color:""},
        },
        methods:{
            add_col(){
                this.cols.push({type:"",name:"",nullable:false});
            },
            deleteCol(index){
                this.cols.splice(index, 1);
            },

            migrate(mdl){
                //display loader
                this.loading_dialog.show = true;

                const app = this;
                axios.post(`/MiMo/${this.name}/${mdl}`, this.cols)
                .then(function (response) {
                    //Run artisan migration
                    app.artisan_migrate();
                    
                    //show result
                    console.log(response);
                    app.ui_responde('success');
                })
                .catch(function (error) {
                    console.log(error);
                    app.ui_responde('fail');
                });
            },

            artisan_migrate(){
                axios.get(`/migrate`)
                .then(function (response) {
                    return true;
                })
                .catch(function (error) {
                    return false;
                });
            },

            ui_responde(response){
                if(response = 'success'){
                    //disable loader
                    this.loading_dialog.show = false;

                    // clean values
                    this.cols = [{type:"",name:"",nullable:false}];
                    this.name = "";

                    // Show dialog with success message
                    this.result_dialog.color = "success";
                    this.result_dialog.text = "Migration complete!";
                    this.result_dialog.show = true;
        
                }else{
                    // Show error dialog
                    this.result_dialog.color = "pink";
                    this.result_dialog.text = "Migration failed!";
                    this.result_dialog.show = true;
                }
            }
        }
    })
  </script>
</body>
</html>