$("#register").click(function () {
  $(".loginBox").slideToggle(400);
  $(".registerBox").slideToggle(400);
});
$("#login").click(function () {
  $(".loginBox").slideToggle(400);
  $(".registerBox").slideToggle(400);
});

function loginAjax() {
  var pass = $("#password").val();
  var username = $("#username").val();
  $.ajax({
    type: "POST",
    data: { pass: pass, username: username },
    url: "assets/ajaxFiles/session.php",
    success: function (data) {
      $("#loginM").html("");
      $("#loginM").append(data);
      $("#loginM").slideDown(500).fadeIn("slow").delay(1000).slideUp(500);
      if (data == true) {
        window.location.href = "http://localhost:8888/mapon/home.php";
      }
    },
  });
}
function registerAjax() {
  var pass = $("#passwordR").val();
  var username = $("#usernameR").val();
  var confirm = $("#confirm").val();
  $.ajax({
    type: "POST",
    data: { pass: pass, username: username, confirm: confirm },
    url: "assets/ajaxFiles/register.php",
    success: function (data) {
      $("#loginM").html("");
      $("#loginM").append(data);
      $("#loginM").slideDown(500).fadeIn("slow").delay(1000).slideUp(500);
      data = JSON.parse(data);
      if (data == "1") {
        window.location.href = "http://localhost:8888/mapon";
      }
    },
  });
}
function product() {
  $(".sortInput").html("");
  var field =
    '<input type="text" name = "product"id = "sort" placeholder ="Enter product"> <button onclick = "list()" class = "searchBtn">Filter by Product<button>';
  $(".sortInput").append(field);
}
function card() {
  $(".sortInput").html("");
  var field =
    '<input type="text" name = "card" id = "sort" placeholder ="Enter card"> <button onclick = "list()" class = "searchBtn">Filter by Card<button>';
  $(".sortInput").append(field);
}
function country() {
  $(".sortInput").html("");
  var field =
    '<input type="text" name = "country" id = "sort" placeholder ="Enter country"> <button onclick = "list()" class = "searchBtn">Filter by Country<button>';
  $(".sortInput").append(field);
}
function date() {
  $(".sortInput").html("");
  var field =
    '<input type="text" name = "date" id = "sort" placeholder ="Enter date"> <button onclick = "list()" class = "searchBtn">Filter by Date<button>';
  $(".sortInput").append(field);
}
function list() {
  if ($('input[name="product"]').length > 0) {
    var where = "product";
  }
  if ($('input[name="country"]').length > 0) {
    var where = "country";
  }
  if ($('input[name="card"]').length > 0) {
    var where = "card_nr";
  }
  if ($('input[name="date"]').length > 0) {
    var where = "date";
  }

  var sort = $("#sort").val();
  $.ajax({
    type: "POST",
    data: { sort: sort, where: where },
    url: "assets/ajaxFiles/list.php",
    success: function (data) {
      $(".list").html("");
      $(".list").append(data);
    },
  });
}
function logout() {
  $.ajax({
    type: "POST",
    url: "assets/ajaxFiles/logout.php",
    success: function () {
      window.location.href = "http://localhost:8888/mapon";
    },
  });
}
