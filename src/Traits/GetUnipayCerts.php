<?php

declare(strict_types=1);

namespace Dehim\Pay\Traits;

use Dehim\Pay\Contract\ConfigInterface;
use Dehim\Pay\Exception\ContainerException;
use Dehim\Pay\Exception\Exception;
use Dehim\Pay\Exception\InvalidConfigException;
use Dehim\Pay\Exception\ServiceNotFoundException;
use Dehim\Pay\Pay;

trait GetUnipayCerts
{
    /**
     * @throws ContainerException
     * @throws InvalidConfigException
     * @throws ServiceNotFoundException
     */
    public function getCertId(string $tenant, array $config): string
    {
        if (!empty($config['certs']['cert_id'])) {
            return $config['certs']['cert_id'];
        }

        $certs = $this->getCerts($config);
        $ssl = openssl_x509_parse($certs['cert'] ?? '');

        if (false === $ssl) {
            throw new InvalidConfigException(Exception::UNIPAY_CONFIG_ERROR, 'Parse `mch_cert_path` Error');
        }

        $certs['cert_id'] = $ssl['serialNumber'] ?? '';

        Pay::get(ConfigInterface::class)->set('unipay.'.$tenant.'.certs', $certs);

        return $certs['cert_id'];
    }

    /**
     * @return array ['cert' => 公钥, 'pkey' => 私钥, 'extracerts' => array]
     *
     * @throws InvalidConfigException
     */
    protected function getCerts(array $config): array
    {
        $path = $config['mch_cert_path'] ?? null;
        $password = $config['mch_cert_password'] ?? null;

        if (is_null($path) || is_null($password)) {
            throw new InvalidConfigException(Exception::UNIPAY_CONFIG_ERROR, 'Missing Unipay Config -- [mch_cert_path] or [mch_cert_password]');
        }

        if (false === openssl_pkcs12_read(file_get_contents($path), $certs, $password)) {
            throw new InvalidConfigException(Exception::UNIPAY_CONFIG_ERROR, 'Read `mch_cert_path` Error');
        }

        return $certs;
    }
}
