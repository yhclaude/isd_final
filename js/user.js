class User {
  static logout() {
    localStorage.clear();
    console.log( 'localStorage is been deleted.');
  }

  static getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
      });
      return vars;
  }
}
