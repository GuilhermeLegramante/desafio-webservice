# desafio-webservice

O objetivo é: Calcular o saldo do tanque de combustível de um veículo levando em consideração os abastecimentos e viagens para cada dia de um período. Ou seja, você terá que descobrir quanto combustível havia no tanque do veículo em cada dia.

Para isso você deve usar os dados disponibilizados nas seguintes URL's:

GET /data/{SEU-ID}/prices: Retorna um array com as datas de alteração do preço do combustível.
GET /data/{SEU-ID}/supplies: Retorna um array com datas e abastecimentos do veículo em reais (não em litros).
GET /data/{SEU-ID}/spents: Retorna um array com datas e uso do veículo em quilômetros (quilometragem percorrida no dia).
O seu veículo possui um consumo estimado de 12km/l.
