<?php
namespace NFHub\SpedMdfe;

use Exception;
use NFHub\Common\Tools as ToolsBase;

/**
 * Classe Tools
 *
 * Classe responsável pela implementação com a API de SpedMdfe do NFHub
 *
 * @category  NFHub
 * @package   NFHub\SpedMdfe\Tools
 * @author    Jefferson Moreira <jeematheus at gmail dot com>
 * @copyright 2021 NFSERVICE
 * @license   https://opensource.org/licenses/MIT MIT
 */
class Tools extends ToolsBase
{
    /**
     * Cadastra um novo certificado digital
     */
    function cadastraCertificado(string $company_cnpj, array $data, array $params = []): array
    {
        try {
            $this->setUpload(true);
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->post('certificates', $data, $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        } finally {
            $this->setUpload(false);
        }
    }

    /**
     * Transmite um MDFe
     */
    function transmiteMdfe(string $company_cnpj, array $data, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->post('mdfes', $data, $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Consulta um MDFe
     */
    function consultaMdfe(string $company_cnpj, int $id, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->get("mdfes/$id", $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Busca a DAMDFE de um MDFe
     */
    function imprimeMdfe(string $company_cnpj, int $id, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $this->setDecode(false);
            $response = $this->get("mdfes/$id/damdfe", $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Busca o XML de um MDFe
     */
    function xmlMdfe(string $company_cnpj, int $id, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $this->setDecode(false);
            $response = $this->get("mdfes/$id/xml", $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Realiza o encerramento de um MDFe
     */
    function closeMdfe(string $company_cnpj, int $id, array $data, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->post("mdfes/$id/close", $data, $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Realiza o encerramento de um MDFe externo
     */
    function closeExternalMdfe(string $company_cnpj, array $data, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->post("mdfes/close", $data, $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }


    /**
     * Realiza o cancelamento de um MDFe
     */
    function cancelMdfe(string $company_cnpj, int $id, array $data, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->post("mdfes/$id/cancel", $data, $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * INclui um novo condutor a um MDFe
     */
    function includeCondutorMdfe(string $company_cnpj, int $id, array $data, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->post("mdfes/$id/condutor", $data, $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Busca o PDF de um concelamento de MDFe
     */
    function imprimeMdfeCancel(string $company_cnpj, int $id, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $this->setDecode(false);
            $response = $this->get("mdfes/$id/cancel/pdf", $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Gera a Pré Damdfe de uma MDFe com base em seus dados
     *
     * @param string $company_cnpj CNPJ da empresa que está gerando a pré danfe
     * @param array $dados Dados da nota fiscal
     * @param array $param Parametros adicionais para a requisição
     */
    public function imprimePreDamdfe(string $company_cnpj, array $dados, array $params = []) :array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $this->setDecode(false);

            $response = $this->post("mdfes/predamdfe", $dados, $params, $headers);

            if ($response['httpCode'] === 200) {
                return $response;
            }

            if (isset($response['body']->errors)) {
                throw new Exception(implode("\r\n", $response['body']->errors), 1);
            }

            if (isset($response['body']->message)) {
                throw new Exception($response['body']->message, 1);
            }

            throw new Exception(json_encode($response), 1);
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    /**
     * Descarta um MDFe
     */
    function descartaMdfe(string $company_cnpj, int $id, array $params = []): array
    {
        try {
            $headers = [
                "company-cnpj: $company_cnpj"
            ];

            $response = $this->delete("mdfes/$id", $params, $headers);

            return $response;
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }
}
