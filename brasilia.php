date_default_timezone_set('America/Sao_Paulo');
require 'xmlseclibs.php';
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
/*$dados=DEVE CONTER SEU OBJETO COM AS INFORMAÇÕES DA NOTA*/
header('Content-Type: text/xml');
if($dados->ambiente_nfse == 1){
$url = 'https://df.issnetonline.com.br/webservicenfse204/nfse.asmx';
}else{
 $url = 'https://www.issnetonline.com.br/apresentacao/df/webservicenfse204/nfse.asmx';   
}
$action = 'http://nfse.abrasf.org.br/GerarNfse';
/*'ccm' =>$dados->inscricao_municipal,
'cnpj'=>$dados->cnpj_emitente,
'cpf'=>$dados->cpf_login,
'senha'=>$dados->senha,
'aliquota'=>$dados->aliquota_issqn,
'servico'=>$dados->codigo_servico,
'situacao'=>$_tributacao_operacao,
'valor'=>$dados->valor,
'base'=>$dados->valor_base,
'ir'=>$dados->valor_ir_retido,
'pis'=>$dados->valor_pis_retido,
'cofins'=>$dados->valor_cofins_retido,
'csll'=>$dados->valor_csll_retido,
'inss'=>$dados->valor_contribuicao_inss,
'retencao_iss'=>$dados->retencao_iss,

'incentivo_fiscal'=>'',
'cod_municipio_prestacao_servico'=>$dados->cod_municipio_prestacao_servico,
'cod_pais_prestacao_servico'=>'',
'cod_municipio_incidencia'=>$dados->cod_municipio_prestacao_servico,
'descricaoNF'=>$dados->descricao_servico,
'tomador_tipo'=>$dados->tomador_tipo,
'tomador_cnpj'=>$dados->tomador_cnpj,
'tomador_email'=>$dados->tomador_email,
'tomador_ie'=>$dados->tomador_inscricao_estadual,
'tomador_im'=>$dados->tomador_inscricao_municipal,
'tomador_razao'=>$dados->tomador_razao_social,
'tomador_endereco'=>$dados->tomador_logradouro,
'tomador_numero'=>$dados->tomador_numero_logradouro,
'tomador_complemento'=>$dados->tomador_complemento,
'tomador_bairro'=>$dados->tomador_bairro,
'tomador_CEP'=>$dados->tomador_CEP,
'tomador_cod_cidade'=>$dados->codigo_municipio,
'tomador_fone'=>$dados->telefone,
'tomador_ramal'=>'',
'tomador_fax'=>'',
'nfse_substituida'=>$dados->nfse_substituida,
'rps_num'=>$dados->numero_rps,
'rps_serie'=>$dados->serie,
'rps_tipo'=>1,
'rps_dia'=>$dia,
'rps_mes'=>$mes,
'rps_ano'=>$ano*/

if($dados->enquadramento_tributario > 2){
    $OptanteSimplesNacional=2;
}else{
   $OptanteSimplesNacional=1;
}
$cnpj_emitente = $dados->cnpj_emitente;
$cnae=$dados->cnae;
$inscricao_municipal=$dados->inscricao_municipal;
$numero_rps=$dados->rps_num;
$serie=$dados->serie;
$tipo=1;
$data_emissao=date('Y-m-d');
$valor_servico=$dados->valor;
$codigo_sevico=$dados->codigo_servico;
$codigo_item='13.05';
$cnpj_cliente=$dados->tomador_cnpj;
$endereco_cliente=$dados->tomador_logradouro;
$bairro_cliente=$dados->tomador_bairro;
$numero_cliente=$dados->tomador_numero_logradouro;
$codigo_municipio_cliente=$dados->codigo_municipio;
$descrica_servico=$dados->descricao_servico;
$uf_cliente=$dados->uf_cliente;
$cep_cliente=$dados->tomador_CEP;
$email_cliente=$dados->tomador_email;
$telefone_cliente=$dados->telefone;
$codigo_municipio_empresa=$dados->cod_municipio_prestacao_servico;

if(strlen($cnpj_cliente)==14){
  $cnpj_cliente="<Cnpj>$cnpj_cliente</Cnpj>";  
}else{
   $cnpj_cliente="<Cpf>$cnpj_cliente</Cpf>";    
}
/*
   <Contato>
                                <Telefone>'.$telefone_cliente.'</Telefone>
                                <Email>'.$email_cliente.'</Email>
                                </Contato>
                                */
$nome_tomador=$dados->tomador_razao_social;


$valor_impostos_vazio='<ValorDeducoes>0</ValorDeducoes>
                                <ValorPis>0.00</ValorPis>
                                <ValorCofins>0.00</ValorCofins>
                                <ValorInss>0.00</ValorInss>
                                <ValorIr>0.00</ValorIr>
                                <ValorCsll>0.00</ValorCsll>
                                <OutrasRetencoes>0</OutrasRetencoes>
                                <ValTotTributos>0</ValTotTributos>
                                <ValorIss>0.00</ValorIss>
                                <Aliquota>2.01</Aliquota>';
                                $valor_impostos_vazio='';
       $xml =  '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:nfse="http://nfse.abrasf.org.br">
	<SOAP-ENV:Body>
		<nfse:GerarNfse>
			<nfseCabecMsg><cabecalho versao="1.00" xmlns="http://www.abrasf.org.br/nfse.xsd"><versaoDados>2.04</versaoDados></cabecalho></nfseCabecMsg>
			<nfseDadosMsg>
				<GerarNfseEnvio xmlns="http://www.abrasf.org.br/nfse.xsd">
				<Rps>
          <InfDeclaracaoPrestacaoServico>
                                <Rps>
                                <IdentificacaoRps>
                                <Numero>'.$numero_rps.'</Numero>
                                <Serie>'.$serie.'</Serie>
                                <Tipo>'.$tipo.'</Tipo>
                                </IdentificacaoRps>
                                <DataEmissao>'.$data_emissao.'</DataEmissao>
                                <Status>1</Status>
                                </Rps>
                                <Competencia>'.$data_emissao.'</Competencia>
                                <Servico>
                                <Valores>
                                <ValorServicos>'.$valor_servico.'</ValorServicos>
                                  '.$valor_impostos_vazio.'
                                </Valores>
                                <IssRetido>2</IssRetido>
                                <ItemListaServico>'.$codigo_item.'</ItemListaServico>
                                <CodigoCnae>'.$cnae.'</CodigoCnae>
                                <CodigoTributacaoMunicipio>'.$codigo_sevico.'</CodigoTributacaoMunicipio>
                                <Discriminacao>'.$descrica_servico.'</Discriminacao>
                                <CodigoMunicipio>'.$codigo_municipio_empresa.'</CodigoMunicipio>
                                <ExigibilidadeISS>1</ExigibilidadeISS>
                                <MunicipioIncidencia>'.$codigo_municipio_empresa.'</MunicipioIncidencia>
                                </Servico>
                                <Prestador>
                                <CpfCnpj>
                                <Cnpj>'.$cnpj_emitente.'</Cnpj>
                                </CpfCnpj>
                                <InscricaoMunicipal>'.$inscricao_municipal.'</InscricaoMunicipal>
                                </Prestador>
                                <TomadorServico>
                                <IdentificacaoTomador>
                                <CpfCnpj>
                                '.$cnpj_cliente.'
                                </CpfCnpj>
                                </IdentificacaoTomador>
                                <RazaoSocial>'.$nome_tomador.'</RazaoSocial><Endereco>
                                <Endereco>'.$endereco_cliente.'</Endereco>
                                <Numero>'.$numero_cliente.'</Numero>
                                <Bairro>'.$bairro_cliente.'</Bairro>
                                <CodigoMunicipio>'.$codigo_municipio_cliente.'</CodigoMunicipio>
                                <Uf>'.$uf_cliente.'</Uf>
                                <Cep>'.$cep_cliente.'</Cep>
                                </Endereco>
                                </TomadorServico>
                                <RegimeEspecialTributacao>1</RegimeEspecialTributacao>
                                <OptanteSimplesNacional>'.$OptanteSimplesNacional.'</OptanteSimplesNacional>
                                <IncentivoFiscal>2</IncentivoFiscal>
                                </InfDeclaracaoPrestacaoServico>

	</Rps>
</GerarNfseEnvio>
			</nfseDadosMsg>
		</nfse:GerarNfse>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';



file_put_contents('brasilia.xml',$xml);
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

$data = file_get_contents($dados->certificado_digital,false, stream_context_create($arrContextOptions));
$certPassword = $dados->senha_certificado;
openssl_pkcs12_read($data, $certs, $certPassword);
$pkey_pem = $certs['pkey'];
$cert_pem = $certs['cert'];
file_put_contents('cert.pem', $cert_pem);
file_put_contents('chave.pem', $pkey_pem);

$doc = new DOMDocument();
$doc->load('brasilia.xml');
$objDSig = new XMLSecurityDSig();
$objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
$objDSig->addReference(
    $doc, 
    XMLSecurityDSig::SHA1, 
    ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 
		'http://www.w3.org/TR/2001/REC-xml-c14n-20010315'],
	['force_uri' => true, 'uri' => 'rpsId23253']	
);

$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type'=>'private'));
$objKey->loadKey('chave.pem', TRUE);
$objDSig->sign($objKey);
$objDSig->add509Cert(file_get_contents('cert.pem'));
$objDSig->appendSignature($doc->getElementsByTagName('Rps')->item(0));
$doc->save('signed.xml');
$xml=file_get_contents('signed.xml');
        $msgSize = strlen($xml);
        $headers = ['Content-Type: text/xml;charset=UTF-8', "SOAPAction: \"$action\"", "Content-length: $msgSize"];

        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 120 + 20);
        curl_setopt($oCurl, CURLOPT_HEADER, 1);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 0);
        //curl_setopt($oCurl, CURLOPT_SSLCERT, $pemPath);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($oCurl);
        $soapErr = curl_error($oCurl);
        $headSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);
       // unlink($pemPath);
        $responseHead = trim(substr($response, 0, $headSize));
        $responseBody = trim(substr($response, $headSize));
        file_put_contents('nota_transmitida.xml',$responseBody);
      
      
      $xml = simplexml_load_string($responseBody);

if(isset($xml->children('s', true)->Body->children()->GerarNfseResponse->children()->GerarNfseResposta->children()->ListaNfse->CompNfse->Nfse->InfNfse)){
$nfse = $xml->children('s', true)->Body->children()->GerarNfseResponse->children()->GerarNfseResposta->children()->ListaNfse->CompNfse->Nfse->InfNfse;
$numero = (string) $nfse->Numero;
$codigoVerificacao = (string) $nfse->CodigoVerificacao;

/*********************************CONSULTA LINK***************************************************/

$action = 'http://nfse.abrasf.org.br/ConsultarUrlNfse';

$xml='<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:nfse="http://nfse.abrasf.org.br">
	<SOAP-ENV:Body>
		<nfse:ConsultarUrlNfse>
			<nfseCabecMsg><cabecalho versao="1.00" xmlns="http://www.abrasf.org.br/nfse.xsd"><versaoDados>2.04</versaoDados></cabecalho></nfseCabecMsg>
			<nfseDadosMsg>
				<ConsultarUrlNfseEnvio xmlns="http://www.abrasf.org.br/nfse.xsd">
	<Pedido>
		<Prestador>
			<CpfCnpj>
				<Cnpj>'.$cnpj_emitente.'</Cnpj>
			</CpfCnpj>
			<InscricaoMunicipal>'.$inscricao_municipal.'</InscricaoMunicipal>
		</Prestador>
		<NumeroNfse>'.$numero.'</NumeroNfse>
		<Pagina>1</Pagina>
	</Pedido>
</ConsultarUrlNfseEnvio>
			</nfseDadosMsg>
		</nfse:ConsultarUrlNfse>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

file_put_contents('brasilia.xml',$xml);

/*CONSULTA**************/
$data = file_get_contents($dados->certificado_digital,false, stream_context_create($arrContextOptions));
$certPassword = $dados->senha_certificado;
openssl_pkcs12_read($data, $certs, $certPassword);
$pkey_pem = $certs['pkey'];
$cert_pem = $certs['cert'];
file_put_contents('cert.pem', $cert_pem);
file_put_contents('chave.pem', $pkey_pem);
$doc = new DOMDocument();
$doc->load('brasilia.xml');
$objDSig = new XMLSecurityDSig();
$objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
$objDSig->addReference(
    $doc, 
    XMLSecurityDSig::SHA1, 
    ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 
		'http://www.w3.org/TR/2001/REC-xml-c14n-20010315'],
	['force_uri' => true, 'uri' => 'rpsId23253']	
);

$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type'=>'private'));
$objKey->loadKey('chave.pem', TRUE);
$objDSig->sign($objKey);
$objDSig->add509Cert(file_get_contents('cert.pem'));
$objDSig->appendSignature($doc->getElementsByTagName('ConsultarUrlNfseEnvio')->item(0));
$doc->save('consulta_url.xml');
$xml=file_get_contents('consulta_url.xml');
$msgSize = strlen($xml);
$headers = ['Content-Type: text/xml;charset=UTF-8', "SOAPAction: \"$action\"", "Content-length: $msgSize"];
        // Setup Curl
        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 120 + 20);
        curl_setopt($oCurl, CURLOPT_HEADER, 1);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 0);
        //curl_setopt($oCurl, CURLOPT_SSLCERT, $pemPath);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($oCurl);
        $soapErr = curl_error($oCurl);

        $headSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);
      
       // unlink($pemPath);
        $responseHead = trim(substr($response, 0, $headSize));
        $responseBody = trim(substr($response, $headSize));

$doc = new DOMDocument();
$doc->loadXML($responseBody);
if(isset($doc->getElementsByTagName('UrlVisualizacaoNfse')->item(0)->nodeValue)){
$link = $doc->getElementsByTagName('UrlVisualizacaoNfse')->item(0)->nodeValue;
}else{
  $link='';  
}
/**********************************************************************/
$retorno = ['Resultado'=>'1','Nota'=>$numero,'autenticidade'=>$codigoVerificacao,'LinkImpressao'=>$link];
echo json_encode($retorno);
}else{
    
    echo 'Erro na transmissão';
    
}
