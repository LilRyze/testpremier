
<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <table class="table">
            <thead>
              <tr>
                <th scope="col" colspan="7" align="center">League Table</th>
                <th scope="col" colspan="5" align="center">Match Results</th>
              </tr>
              <tr>
                <td>Teams</td>
                <td>PTS</td>
                <td>P</td>
                <td>W</td>
                <td>D</td>
                <td>L</td>
                <td>GD</td>
                <td align="center" colspan="5">Week Match Results</td>
              </tr>
              
            </thead>
            <tbody>
              <tr v-for="team in teams" :key="team.id">
                <td>{{team.name}}</td>
                <td>{{team.pts}}</td>
                <td>{{team.played}}</td>
                <td>{{team.wins}}</td>
                <td>{{team.draws}}</td>
                <td>{{team.loses}}</td>
                <td>{{team.gd}}</td>
                <td>{{team.name}}</td>
                <td>3</td>
                <td>-</td>
                <td>1</td>
                <td>{{team.name}}</td>
              </tr>
              <tr>
                <th colspan="7"><button type="button" class="btn btn-dark" @click="playAll">Play All</button></th>
                <th colspan="5"><button type="button" class="btn btn-success" @click="playOne">Next Week</button></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'Home',
    data () {
      return {
        teams: {},
        results: {},
        currentWeek: 0,
      }
    },
    created () {
      this.getTeams();
      this.getResults();
    },
    methods: {
      async getTeams() {
        try {
          let response = await axios.get('/api/get_teams');
          this.teams = response.data;
        } catch(error) {
          this.teams = null;
          console.log(error);
        }
      },
      async getResults() {
        try {
          let response = await axios.get('/api/get_results');
          this.results = response.data;
        } catch(error) {
          this.results = null;
          console.log(error);
        }
      },
      async playOne() {
        try {
          // this.currentWeek = this.currentWeek + 1;
          let response = await axios.post('/api/play_one', {
            currentWeek: this.currentWeek
          });
          console.log(response);
        } catch(error) {
          console.log(error);
        }
      },
      async playAll() {
        try {
          let response = await axios.get('/api/play_all');
          console.log(response);
        } catch(error) {
          console.log(error);
        }
      }
    }
}
</script>