class User {
  static logout() {
      console.log("bye");
      localStorage.clear();
      window.location.href = "http://localhost/isd_final/index.html";
  }

  static renderBtn() {
      var name = localStorage.getItem('username');
      var sess = localStorage.getItem('sess');
      // loginBtn
      var loginDiv = document.getElementById("login-button");
      if (sess) {
          loginDiv.innerHTML= '<a id="loginBtn" onclick="User.logout()">Staff Login</a>';
      } else {
          loginDiv.innerHTML = '<a data-toggle="modal" data-target="#userModal" id="loginBtn">Staff Login</a>';
      }

      var loginBtn = document.getElementById("loginBtn");
      loginBtn.innerHTML = (name)? ("Hi, "+name+" | "+" Logout") : "Staff Login"

      window.scrollTo(0, 0);
  }

  static getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
      });
      return vars;
  }
}
