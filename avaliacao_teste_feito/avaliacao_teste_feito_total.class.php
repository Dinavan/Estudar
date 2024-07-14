<?php

class avaliacao_teste_feito_total
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;

   var $nm_data;

   //----- 
   function avaliacao_teste_feito_total($sc_page)
   {
      $this->sc_page = $sc_page;
      $this->nm_data = new nm_data("pt_br");
      if (isset($_SESSION['sc_session'][$this->sc_page]['avaliacao_teste_feito']['campos_busca']) && !empty($_SESSION['sc_session'][$this->sc_page]['avaliacao_teste_feito']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->resp = $Busca_temp['resp']; 
          $tmp_pos = strpos($this->resp, "##@@");
          if ($tmp_pos !== false)
          {
              $this->resp = substr($this->resp, 0, $tmp_pos);
          }
          $this->u512969981_respostas_conferidas_id_questao = $Busca_temp['u512969981_respostas_conferidas_id_questao']; 
          $tmp_pos = strpos($this->u512969981_respostas_conferidas_id_questao, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_conferidas_id_questao = substr($this->u512969981_respostas_conferidas_id_questao, 0, $tmp_pos);
          }
          $this->u512969981_respostas_conferidas_materia_id_materia = $Busca_temp['u512969981_respostas_conferidas_materia_id_materia']; 
          $tmp_pos = strpos($this->u512969981_respostas_conferidas_materia_id_materia, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_conferidas_materia_id_materia = substr($this->u512969981_respostas_conferidas_materia_id_materia, 0, $tmp_pos);
          }
          $u512969981_respostas_conferidas_materia_id_materia_2 = $Busca_temp['u512969981_respostas_conferidas_materia_id_materia_input_2']; 
          $this->u512969981_respostas_conferidas_materia_id_materia_2 = $Busca_temp['u512969981_respostas_conferidas_materia_id_materia_input_2']; 
          $this->u512969981_respostas_conferidas_u512969981_questao = $Busca_temp['u512969981_respostas_conferidas_u512969981_questao']; 
          $tmp_pos = strpos($this->u512969981_respostas_conferidas_u512969981_questao, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_conferidas_u512969981_questao = substr($this->u512969981_respostas_conferidas_u512969981_questao, 0, $tmp_pos);
          }
          $this->u512969981_respostas_conferidas_aluno = $Busca_temp['u512969981_respostas_conferidas_aluno']; 
          $tmp_pos = strpos($this->u512969981_respostas_conferidas_aluno, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_conferidas_aluno = substr($this->u512969981_respostas_conferidas_aluno, 0, $tmp_pos);
          }
          $this->u512969981_respostas_conferidas_teste = $Busca_temp['u512969981_respostas_conferidas_teste']; 
          $tmp_pos = strpos($this->u512969981_respostas_conferidas_teste, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_conferidas_teste = substr($this->u512969981_respostas_conferidas_teste, 0, $tmp_pos);
          }
          $this->u512969981_respostas_id_resposta = $Busca_temp['u512969981_respostas_id_resposta']; 
          $tmp_pos = strpos($this->u512969981_respostas_id_resposta, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_id_resposta = substr($this->u512969981_respostas_id_resposta, 0, $tmp_pos);
          }
          $u512969981_respostas_id_resposta_2 = $Busca_temp['u512969981_respostas_id_resposta_input_2']; 
          $this->u512969981_respostas_id_resposta_2 = $Busca_temp['u512969981_respostas_id_resposta_input_2']; 
          $this->u512969981_respostas_questao_id_questao = $Busca_temp['u512969981_respostas_questao_id_questao']; 
          $tmp_pos = strpos($this->u512969981_respostas_questao_id_questao, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_questao_id_questao = substr($this->u512969981_respostas_questao_id_questao, 0, $tmp_pos);
          }
          $u512969981_respostas_questao_id_questao_2 = $Busca_temp['u512969981_respostas_questao_id_questao_input_2']; 
          $this->u512969981_respostas_questao_id_questao_2 = $Busca_temp['u512969981_respostas_questao_id_questao_input_2']; 
          $this->u512969981_respostas_alternativa_id_alternativa = $Busca_temp['u512969981_respostas_alternativa_id_alternativa']; 
          $tmp_pos = strpos($this->u512969981_respostas_alternativa_id_alternativa, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_alternativa_id_alternativa = substr($this->u512969981_respostas_alternativa_id_alternativa, 0, $tmp_pos);
          }
          $u512969981_respostas_alternativa_id_alternativa_2 = $Busca_temp['u512969981_respostas_alternativa_id_alternativa_input_2']; 
          $this->u512969981_respostas_alternativa_id_alternativa_2 = $Busca_temp['u512969981_respostas_alternativa_id_alternativa_input_2']; 
          $this->u512969981_respostas_respondi = $Busca_temp['u512969981_respostas_respondi']; 
          $tmp_pos = strpos($this->u512969981_respostas_respondi, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_respostas_respondi = substr($this->u512969981_respostas_respondi, 0, $tmp_pos);
          }
          $u512969981_respostas_respondi_2 = $Busca_temp['u512969981_respostas_respondi_input_2']; 
          $this->u512969981_respostas_respondi_2 = $Busca_temp['u512969981_respostas_respondi_input_2']; 
          $this->u512969981_gabarito_questao_id_questao = $Busca_temp['u512969981_gabarito_questao_id_questao']; 
          $tmp_pos = strpos($this->u512969981_gabarito_questao_id_questao, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_gabarito_questao_id_questao = substr($this->u512969981_gabarito_questao_id_questao, 0, $tmp_pos);
          }
          $u512969981_gabarito_questao_id_questao_2 = $Busca_temp['u512969981_gabarito_questao_id_questao_input_2']; 
          $this->u512969981_gabarito_questao_id_questao_2 = $Busca_temp['u512969981_gabarito_questao_id_questao_input_2']; 
          $this->u512969981_gabarito_alternativa_id_alternativa = $Busca_temp['u512969981_gabarito_alternativa_id_alternativa']; 
          $tmp_pos = strpos($this->u512969981_gabarito_alternativa_id_alternativa, "##@@");
          if ($tmp_pos !== false)
          {
              $this->u512969981_gabarito_alternativa_id_alternativa = substr($this->u512969981_gabarito_alternativa_id_alternativa, 0, $tmp_pos);
          }
          $u512969981_gabarito_alternativa_id_alternativa_2 = $Busca_temp['u512969981_gabarito_alternativa_id_alternativa_input_2']; 
          $this->u512969981_gabarito_alternativa_id_alternativa_2 = $Busca_temp['u512969981_gabarito_alternativa_id_alternativa_input_2']; 
      } 
   }

   //---- 
   function quebra_geral()
   {
      global $nada, $nm_lang ;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['contr_total_geral'] == "OK") 
      { 
          return; 
      } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['tot_geral'] = array() ;  
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['where_pesq']; 
      } 
      else 
      { 
          $nm_comando = "select count(*) from " . $this->Ini->nm_tabela . " " . $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['where_pesq']; 
      } 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando;
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = '';
      if (!$rt = $this->Db->Execute($nm_comando)) 
      { 
         $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
         exit ; 
      }
      $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['tot_geral'][0] = "" . $this->Ini->Nm_lang['lang_msgs_totl'] . ""; 
      $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['tot_geral'][1] = $rt->fields[0] ; 
      $rt->Close(); 
      $_SESSION['sc_session'][$this->Ini->sc_page]['avaliacao_teste_feito']['contr_total_geral'] = "OK";
   } 

   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($cont2 >= $tam_campo)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $trab_saida;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $trab_saida;
   } 
}

?>
