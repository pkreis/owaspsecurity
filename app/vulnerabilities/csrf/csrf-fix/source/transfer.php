<h2>Transfer punktów</h2>
<?php
if(isset($_SESSION['info'])){
    echo "<p>".$_SESSION['info']."</p>";
}
?>
<form action="vulnerabilities/csrf/csrf-fix/index.php?action=transfer" method="post">
    <label for="userid">Odbiorca: </label>
    <select name="userid" id="userid">
        <?php foreach($users as $u):?>
        <option value="<?php echo $u['id']?>"><?php echo $u['nazwa']?></option>
        <?php endforeach; ?>
    </select>
    <label for="points">Ilość punktów do przekazania: </label>
    <input type="number" name="points" id="points" 
        <?php if (intval($ammount)>0) 
         {echo "value='1' min='1' max='$ammount'";}
         else {echo "value='0' readonly='readonly'";} 
        ?>
    >
    <input type="submit" value="Przekaż" class='btn' 
        <?php if (intval($ammount) < 0) 
         {echo "disabled='disabled'";}
        ?>
    >
    <input type="hidden" name="token" value="<?php echo $token ;?>">
</form>

<div>Użytkownik: <strong><?php echo $user; ?></strong></div>
<div>Ilość punktów: <strong><?php if (!$ammount){ echo 'brak danych'; } else { echo $ammount; } ;?></strong> pkt</div>
<br>
<div><a href="vulnerabilities/csrf/csrf-fix/index.php?action=logout" class="button">Wylogowanie</a></div>