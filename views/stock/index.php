<?php require '../../src/includes/_header.php'?>
<?php require '../../src/includes/_db.php'?>
<?php require '../../src/structures/item_viewer.php'?>
<?php require '../../src/structures/item_add.php'?>
<?php require '../../src/structures/item_edit.php'?>
<?php require '../../src/structures/item_remove.php'?>
<body>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<?php
    $categoria = $_GET['room'];
    $session_query = "SELECT name_place FROM places WHERE id_place = $categoria";
    $session_result = mysqli_query($db, $session_query);
    $session_name = mysqli_fetch_assoc($session_result)['name_place'];

    $item_query = "SELECT * FROM item WHERE id_place = $categoria";
    $item_result = mysqli_query($db, $item_query);
?>

<div class="main-container">
    <h1><?php echo ucfirst(strtolower($session_name))?> <span>(<?php echo mysqli_num_rows($item_result)?>)</span></h1>
    <div class="main-container-action">

    </div>
</div>
<div class="products-interaction">
    <input type="text" id="search_item" name="search_item" placeholder="Pesquisar por código, nome, categoria, status ou ano" autocomplet="off">
    
    <div class="group-interaction">
    <div class="dropdown">
            <p id="pdf-creator-btn" class="material-symbols-outlined" title="Gerar documento" onclick="toggle()">file_open</p>

        <ul class="dropdown-list">
          <li class="dropdown-list-item" id="export_pdf_1">
            <span class="material-symbols-outlined">deployed_code_update</span>
              Todas os ambientes
          </li>

          <li class="dropdown-list-item" id="export_pdf_2">
            <span class="material-symbols-outlined">deployed_code_update</span>
              Ambiente atual
          </li>

          <li class="dropdown-list-item" id="export_pdf_3">
            <span class="material-symbols-outlined">deployed_code_update</span>
              Insensíveis
          </li>
        </ul>
      </div>

    <a class="main-btn _modal_add_open"><span class="material-icons">add</span>Novo item</a> 
    </div>
    </div>

    <div class="products-container">
        <div class="table-container" id="tableContainer" >
        </div>
    </div>

    <div id="conteudo"></div>

<script>
  $(document).ready(function(){
    let place = new URLSearchParams(window.location.search).get('room');
    load_data();

    function load_data(query) {
      $.ajax({
        url:"../../src/structures/loaders/item_searcher.php",
        method:"POST",
        data:{
        query: query,
        place: place
      },
      success:function(data)
      {
        $('#tableContainer').html(data);
      }
      });
    }

    $('#search_item').keyup(function(){
      var search = $(this).val();
      if (search != '') load_data(search);
      else load_data();
    });
  });
</script>

<script>
  let profileDropdownList = document.querySelector(".dropdown-list");
  let btn = document.querySelector("#pdf-creator-btn");

  let classList = profileDropdownList.classList;

  const toggle = () => classList.toggle("active");

  window.addEventListener("click", function (e) {
    if (!btn.contains(e.target)) classList.remove("active");
  });
</script>

<script src="../../src/js/viewItem.js"></script>
<script src="../../src/js/fileImport.js"></script>
<script src="../../src/js/modal.js"></script>
<script src="../../src/js/pdfCreator.js"></script>
</html>