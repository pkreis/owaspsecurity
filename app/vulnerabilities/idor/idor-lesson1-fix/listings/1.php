<select size='6' name="id">
    <?php foreach($messages as $message):
       if(!isset($_SESSION['zalogowany']) && $message['registered']){
         $dis = 'disabled="disabled"';
         $id = '0';
       }
       else{
         $dis = '';
         $id = $message['id'];
       }
    ?>
    <option value="<?php echo $id; ?>" <?php echo $dis; ?>><?php echo $message['title']?></option>
    <?php endforeach; ?>
  </select>
