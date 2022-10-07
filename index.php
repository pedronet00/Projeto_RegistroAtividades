<?php 
    
    include('conexao.php');

    $const_valor = 50;

    if(isset($_POST['acao'])){
        
        $hora_inicial = $_POST['inicial'];
        $hora_final = $_POST['final'];
        $hoje = date('Y-m-d');
        
        
        //formatação de datas e valores
        $diffHoras = (strtotime($hora_final) - strtotime($hora_inicial))-3600;
        $total_horas = date('H:i:s', $diffHoras);
        $min = date('i', $total_horas) / 60;
        $seg = date('s', $total_horas) / 3600;
        $parte_frac = $min + $seg;
        $hora_convertida_decimal = date('H', $diffHoras) + $parte_frac;
        $total_ganho_custo = $const_valor * $hora_convertida_decimal;
        $total_ganho_formatado = number_format($total_ganho_custo, 2, '.', '');
        
        
        
        $inserir = "INSERT INTO registro(hora_inicial, hora_final, data_registro, total_horas, total_ganho) VALUES ('$hora_inicial', '$hora_final', '$hoje', '$total_horas', '$total_ganho_formatado')";
        $result = mysqli_query($conn, $inserir);
    }

    $selecionar = "SELECT * FROM registro";
    $result_selecionar = mysqli_query($conn, $selecionar);

    $total_ganho = "SELECT SUM(total_ganho) AS total FROM registro";
    $result_ganho = mysqli_query($conn, $total_ganho);
    $linha_ganho = mysqli_fetch_assoc($result_ganho);
    

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Contador de Horas Trabalhadas</title>
    
<script language=javascript type="text/javascript">
    dayName = new Array ("Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado")
    monName = new Array ("janeiro", "fevereiro", "março", "abril", "maio", "junho", "agosto", "outubro", "novembro", "dezembro")
    now = new Date
</script>
    
<style>
    *{
        font-family: arial;
        margin: 0;
    }
    
    
    
    header{
        width: 100%;
        height: 100px;
        color: white;
        background-color: #4E598C;
        text-align: center;
        font-size: 35px;
    }
    
    .formulario{
        text-align: center;
    }
    
    .hora_inicial{
        display: inline-block;
        padding: 2%;
    }
    
    .hora_final{
        display: inline-block;
    }
    
    .tabela{
        margin-left: 35%;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        border: collapse;
        width: 50%;
        min-width: 300px;
        margin: auto;
    }
    
    
  #conteudo {
		width: 70%;
		float: right;
		text-align: center;
		}
    
    #menu {
		width: 30%;
		margin: 0; 
        padding: 0;
		float: left;
        height: 874px;
        text-align: center;
        background-color: #FCAF58;
/*        border: 2px solid black;*/
		}
    
    #menu ul li {
		margin: 0; padding: 0px;
		border-bottom: 1px solid #CCC;
		text-align: left;
		list-style-type: none;
		}
    
    #menu a:link {
		background: #F5F5F5;
		color: #666;
		font-weight: bold;
		text-decoration: none;
		padding: 8px;
		display: block;
		}
    
    #menu a:hover {
		background: #E5F0FF;
		color: #039;
		}
    
    .infos{
        margin-top: 5%;
        text-align: left;
        font-size: 20px;
    }
    
    h3{
        margin-top: 65%;
        text-align: center;
    }
    
    p{
        margin-left: 1%;
    }
   
    .tudo_menu{
        margin-top: 10%;
    }
    
</style>
</head>

<body style="background-color: #F9C784">

    <header>
        <h1>Registro de Atividades</h1>
    </header>
    
    
    
    
    
    
    
        

<div id="menu">
        
    <br/>
        
	  <img src='user_icon.png' height="250px" width="250px">
        <p style="font-size: 20px;"><b>Joãozinho da Silva</b></p>
        
        <div class="infos">
            <p>Idade: <b>26 anos</b></p>
            <p>Cidade: <b>São Paulo</b></p>
            <p>Empresa: <b>Empresa Fictícia</b></p>
            <p>Anos na Empresa: <b>5 anos, 2 meses</b></p>
            <p>Função: <b>Desenvolvedor Sênior</b></p>
            <?php echo "<p>Custo por hora: <b>R$". $const_valor. ",00</b></p>"; ?>
          
        </div>  
        
    <?php echo "<h3>TOTAL GANHO ATÉ HOJE: R$ ". number_format($linha_ganho['total'], 2, '.', '') . "</h3>"?>
    
</div>
    
    <script language=javascript type="text/javascript">
        document.write ("<h4 style='margin-left: 56%; margin-top: 1%;'> Olá! Hoje é " + dayName[now.getDay() ] + ", " + now.getDate () + " de " + monName [now.getMonth()-2 ]   +  " de "  +     now.getFullYear () + ". </h4>")
    </script>
    
        <form method="POST" class="formulario" action="index.php">

            <input type="hidden" name="acao" value="acao">

            <div class="hora_inicial">
                <h2>Insira a Hora Inicial:</h2>
                <input type="time" value="inicial" name="inicial" placeholder="Insira que horas você começou a trabalhar:">
            </div>

            <div class="hora_final">
                <h2>Insira a Hora Final:</h2>
                <input type="time" value="final" name="final" placeholder="Insira que horas você acabou de trabalhar:">
            </div>

            <input type="submit" class="salvar" name="enviar" value="Salvar">
        </form>

        <table class="tabela">
            <tr>
                <th style="background-color: #4E598C; color: white;">Data</th>
                <th style="background-color: #4E598C; color: white;">Hora - Início</th>
                <th style="background-color: #4E598C; color: white;">Hora - Fim</th>
                <th style="background-color: #4E598C; color: white;">Horas trabalhadas</th>
                <th style="background-color: #4E598C; color: white;">Total R$</th>
            </tr>
            <?php while($linha_selecionar = mysqli_fetch_assoc($result_selecionar)){?>
            <tr>
                <th><?php echo $linha_selecionar['data_registro']; ?></th>
                <th><?php echo $linha_selecionar['hora_inicial']; ?></th>
                <th><?php echo $linha_selecionar['hora_final']; ?></th>
                <th><?php echo $linha_selecionar['total_horas']; ?></th>
                <th><?php echo "R$ " .$linha_selecionar['total_ganho']; ?></th>
            </tr>


            <?php } ?>
        </table>
    
</body>
</html>