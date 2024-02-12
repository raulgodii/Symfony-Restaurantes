<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categoria;
use App\Entity\Producto;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear categorías
        $categorias = [
            ['nombre' => 'Alimentos frescos', 'descripcion' => 'Ingredientes frescos para cocinar'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Bebidas variadas para restaurantes'],
            ['nombre' => 'Equipamiento de cocina', 'descripcion' => 'Utensilios y equipos para cocinar'],
            ['nombre' => 'Vajilla y cubiertos', 'descripcion' => 'Platos, vasos, cubiertos, etc.'],
            ['nombre' => 'Productos de limpieza', 'descripcion' => 'Productos para la limpieza y mantenimiento'],
            ['nombre' => 'Mobiliario', 'descripcion' => 'Muebles para restaurantes'],
        ];

        $categoriasObject = [];

        foreach ($categorias as $catData) {
            $categoria = new Categoria();
            $categoria->setNombre($catData['nombre']);
            $categoria->setDescripcion($catData['descripcion']);

            array_push($categoriasObject, $categoria);

            // Persiste la categoría en la base de datos
            $manager->persist($categoria);
        }

        // Crear productos
        $productos = [
            // Datos de los productos para la categoría 'Alimentos frescos'
            [
                'nombre' => 'Filete de salmón',
                'descripcion' => 'Filete fresco de salmón',
                'peso' => 200,
                'stock' => 50,
                'imagen' => 'salmon.jpg',
                'categoria' => 'Alimentos frescos',
            ],
            [
                'nombre' => 'Pechuga de pollo',
                'descripcion' => 'Pechuga de pollo deshuesada',
                'peso' => 150,
                'stock' => 80,
                'imagen' => 'pollo.jpg',
                'categoria' => 'Alimentos frescos',
            ],
            [
                'nombre' => 'Arroz integral',
                'descripcion' => 'Arroz integral de grano largo',
                'peso' => 1000,
                'stock' => 120,
                'imagen' => 'arroz.jpg',
                'categoria' => 'Alimentos frescos',
            ],
            [
                'nombre' => 'Manzanas orgánicas',
                'descripcion' => 'Manzanas frescas orgánicas',
                'peso' => 500,
                'stock' => 60,
                'imagen' => 'manzanas.jpg',
                'categoria' => 'Alimentos frescos',
            ],
            [
                'nombre' => 'Zanahorias frescas',
                'descripcion' => 'Zanahorias orgánicas recién recolectadas',
                'peso' => 600,
                'stock' => 80,
                'imagen' => 'zanahorias.jpg',
                'categoria' => 'Alimentos frescos',
            ],
            [
                'nombre' => 'Yogur natural',
                'descripcion' => 'Yogur natural sin azúcar añadido',
                'peso' => 150,
                'stock' => 40,
                'imagen' => 'yogur.jpg',
                'categoria' => 'Alimentos frescos',
            ],
            [
                'nombre' => 'Brócoli fresco',
                'descripcion' => 'Brócoli fresco recién cortado',
                'peso' => 300,
                'stock' => 70,
                'imagen' => 'brocoli.jpg',
                'categoria' => 'Alimentos frescos',
            ],

            // Datos de los productos para la categoría 'Bebidas'
            [
                'nombre' => 'Agua mineral',
                'descripcion' => 'Botella de agua mineral',
                'peso' => 500,
                'stock' => 100,
                'imagen' => 'agua.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Vino tinto reserva',
                'descripcion' => 'Botella de vino tinto reserva',
                'peso' => 750,
                'stock' => 30,
                'imagen' => 'vino.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Refresco de cola',
                'descripcion' => 'Lata de refresco de cola',
                'peso' => 330,
                'stock' => 120,
                'imagen' => 'cola.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Cerveza artesanal IPA',
                'descripcion' => 'Botella de cerveza artesanal India Pale Ale',
                'peso' => 500,
                'stock' => 60,
                'imagen' => 'ipa.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Jugo de naranja natural',
                'descripcion' => 'Botella de jugo de naranja recién exprimido',
                'peso' => 1000,
                'stock' => 80,
                'imagen' => 'jugo_naranja.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Té verde',
                'descripcion' => 'Caja de bolsitas de té verde',
                'peso' => 50,
                'stock' => 200,
                'imagen' => 'te_verde.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Café espresso',
                'descripcion' => 'Taza de café espresso recién preparado',
                'peso' => 30,
                'stock' => 150,
                'imagen' => 'cafe_espresso.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Refresco de limón',
                'descripcion' => 'Lata de refresco de limón',
                'peso' => 330,
                'stock' => 100,
                'imagen' => 'limon.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Agua con gas',
                'descripcion' => 'Botella de agua con gas',
                'peso' => 500,
                'stock' => 80,
                'imagen' => 'agua_con_gas.jpg',
                'categoria' => 'Bebidas',
            ],
            [
                'nombre' => 'Leche de almendras',
                'descripcion' => 'Botella de leche de almendras',
                'peso' => 1000,
                'stock' => 70,
                'imagen' => 'leche_almendras.jpg',
                'categoria' => 'Bebidas',
            ],

            // Datos de los productos para la categoría 'Equipamiento de Cocina'
            [
                'nombre' => 'Set de cuchillos de chef',
                'descripcion' => 'Set de cuchillos de chef profesionales con bloque de madera',
                'peso' => 1500,
                'stock' => 20,
                'imagen' => 'cuchillos_chef.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Sartén antiadherente',
                'descripcion' => 'Sartén de aluminio fundido con recubrimiento antiadherente',
                'peso' => 800,
                'stock' => 40,
                'imagen' => 'sarten.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Báscula digital de cocina',
                'descripcion' => 'Báscula digital de precisión para pesar ingredientes',
                'peso' => 300,
                'stock' => 50,
                'imagen' => 'bascula.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Juego de ollas y sartenes',
                'descripcion' => 'Juego completo de ollas y sartenes de acero inoxidable',
                'peso' => 5000,
                'stock' => 10,
                'imagen' => 'ollas_sartenes.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Batidora de mano',
                'descripcion' => 'Batidora de mano eléctrica con múltiples velocidades',
                'peso' => 1000,
                'stock' => 15,
                'imagen' => 'batidora.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Molinillo de café',
                'descripcion' => 'Molinillo eléctrico de café con ajuste de molido',
                'peso' => 800,
                'stock' => 25,
                'imagen' => 'molinillo_cafe.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Tabla de cortar de bambú',
                'descripcion' => 'Tabla de cortar de bambú ecológica y resistente',
                'peso' => 1200,
                'stock' => 30,
                'imagen' => 'tabla_cortar.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Exprimidor de cítricos',
                'descripcion' => 'Exprimidor manual de cítricos de acero inoxidable',
                'peso' => 500,
                'stock' => 35,
                'imagen' => 'exprimidor.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Termómetro de cocina',
                'descripcion' => 'Termómetro digital de cocina para medir la temperatura de los alimentos',
                'peso' => 50,
                'stock' => 40,
                'imagen' => 'termometro_cocina.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],
            [
                'nombre' => 'Espátulas de silicona',
                'descripcion' => 'Set de espátulas de cocina de silicona resistentes al calor',
                'peso' => 200,
                'stock' => 60,
                'imagen' => 'espatulas_silicona.jpg',
                'categoria' => 'Equipamiento de cocina',
            ],

            // Datos de los productos para la categoría 'Vajilla y cubiertos'
            [
                'nombre' => 'Juego de platos de porcelana',
                'descripcion' => 'Juego de platos de porcelana blanca para 6 personas',
                'peso' => 3000,
                'stock' => 20,
                'imagen' => 'platos_porcelana.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Juego de cubiertos de acero inoxidable',
                'descripcion' => 'Juego completo de cubiertos de acero inoxidable para 12 personas',
                'peso' => 2000,
                'stock' => 30,
                'imagen' => 'cubiertos_acero.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Vaso de cristal',
                'descripcion' => 'Vaso de cristal transparente de alta calidad',
                'peso' => 200,
                'stock' => 100,
                'imagen' => 'vaso_cristal.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Juego de tazas de café',
                'descripcion' => 'Juego de tazas de café de cerámica con platillos',
                'peso' => 1500,
                'stock' => 25,
                'imagen' => 'tazas_cafe.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Juego de copas de vino',
                'descripcion' => 'Juego de copas de vino de cristal para 6 personas',
                'peso' => 2500,
                'stock' => 15,
                'imagen' => 'copas_vino.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Cuchara de servir',
                'descripcion' => 'Cuchara de servir de acero inoxidable resistente',
                'peso' => 150,
                'stock' => 50,
                'imagen' => 'cuchara_servir.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Plato hondo de cerámica',
                'descripcion' => 'Plato hondo de cerámica para sopas y guisos',
                'peso' => 1000,
                'stock' => 40,
                'imagen' => 'plato_hondo.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Tenedor de postre',
                'descripcion' => 'Tenedor de postre de acero inoxidable para servir postres',
                'peso' => 100,
                'stock' => 60,
                'imagen' => 'tenedor_postre.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Jarra de agua',
                'descripcion' => 'Jarra de agua de vidrio con tapa y asa',
                'peso' => 800,
                'stock' => 35,
                'imagen' => 'jarra_agua.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],
            [
                'nombre' => 'Juego de platos de postre',
                'descripcion' => 'Juego de platos de postre de porcelana para 6 personas',
                'peso' => 2000,
                'stock' => 20,
                'imagen' => 'platos_postre.jpg',
                'categoria' => 'Vajilla y cubiertos',
            ],

            // Datos de los productos para la categoría 'Productos de limpieza'
            [
                'nombre' => 'Detergente líquido para platos',
                'descripcion' => 'Detergente líquido concentrado para lavar platos a mano',
                'peso' => 1000,
                'stock' => 50,
                'imagen' => 'detergente_platos.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Limpiador multiusos',
                'descripcion' => 'Limpiador multiusos en spray para superficies',
                'peso' => 750,
                'stock' => 40,
                'imagen' => 'limpiador_multiusos.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Jabón en barra',
                'descripcion' => 'Jabón en barra para lavar a mano',
                'peso' => 150,
                'stock' => 60,
                'imagen' => 'jabon_barra.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Desinfectante en gel',
                'descripcion' => 'Gel desinfectante para manos y superficies',
                'peso' => 500,
                'stock' => 70,
                'imagen' => 'desinfectante_gel.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Esponja de limpieza',
                'descripcion' => 'Esponja de limpieza resistente para fregar',
                'peso' => 50,
                'stock' => 100,
                'imagen' => 'esponja_limpieza.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Toallitas desinfectantes',
                'descripcion' => 'Toallitas desinfectantes para limpiar superficies',
                'peso' => 200,
                'stock' => 80,
                'imagen' => 'toallitas_desinfectantes.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Quitamanchas en spray',
                'descripcion' => 'Quitamanchas en spray para ropa y tejidos',
                'peso' => 400,
                'stock' => 45,
                'imagen' => 'quitamanchas_spray.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Desengrasante industrial',
                'descripcion' => 'Desengrasante industrial concentrado para cocinas',
                'peso' => 1000,
                'stock' => 30,
                'imagen' => 'desengrasante_industrial.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Lavandina',
                'descripcion' => 'Lavandina líquida para desinfectar y blanquear',
                'peso' => 1500,
                'stock' => 25,
                'imagen' => 'lavandina.jpg',
                'categoria' => 'Productos de limpieza',
            ],
            [
                'nombre' => 'Limpiador de vidrios',
                'descripcion' => 'Limpiador de vidrios en aerosol para cristales y espejos',
                'peso' => 600,
                'stock' => 35,
                'imagen' => 'limpiavidrios.jpg',
                'categoria' => 'Productos de limpieza',
            ],

            // Datos de los productos para la categoría 'Mobiliario'
            [
                'nombre' => 'Mesa de comedor rectangular',
                'descripcion' => 'Mesa de comedor de madera maciza con capacidad para 6 personas',
                'peso' => 35000,
                'stock' => 15,
                'imagen' => 'mesa_comedor.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Silla de comedor acolchada',
                'descripcion' => 'Silla de comedor tapizada en tela con respaldo alto y cómodo',
                'peso' => 8000,
                'stock' => 20,
                'imagen' => 'silla_comedor.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Sofá de tres plazas',
                'descripcion' => 'Sofá tapizado en cuero sintético con reposabrazos acolchados',
                'peso' => 30000,
                'stock' => 10,
                'imagen' => 'sofa_tres_plazas.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Mesa de centro de vidrio',
                'descripcion' => 'Mesa de centro moderna con superficie de vidrio templado y patas cromadas',
                'peso' => 15000,
                'stock' => 25,
                'imagen' => 'mesa_centro_vidrio.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Armario de cocina',
                'descripcion' => 'Armario de cocina con puertas de madera y estantes ajustables',
                'peso' => 40000,
                'stock' => 12,
                'imagen' => 'armario_cocina.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Cama individual',
                'descripcion' => 'Cama individual con estructura de metal y colchón de espuma viscoelástica',
                'peso' => 25000,
                'stock' => 18,
                'imagen' => 'cama_individual.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Mesa auxiliar',
                'descripcion' => 'Mesa auxiliar con diseño moderno y patas de acero inoxidable',
                'peso' => 7000,
                'stock' => 30,
                'imagen' => 'mesa_auxiliar.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Cómoda de dormitorio',
                'descripcion' => 'Cómoda de madera con cajones espaciosos y tiradores metálicos',
                'peso' => 35000,
                'stock' => 15,
                'imagen' => 'comoda_dormitorio.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Silla de escritorio ergonómica',
                'descripcion' => 'Silla de escritorio ajustable en altura y respaldo reclinable',
                'peso' => 12000,
                'stock' => 20,
                'imagen' => 'silla_escritorio.jpg',
                'categoria' => 'Mobiliario',
            ],
            [
                'nombre' => 'Mesa de reuniones',
                'descripcion' => 'Mesa de reuniones con superficie de melamina y capacidad para 8 personas',
                'peso' => 50000,
                'stock' => 10,
                'imagen' => 'mesa_reuniones.jpg',
                'categoria' => 'Mobiliario',
            ]

        ];

        // Crear y persistir los productos
        foreach ($productos as $productoData) {
            $producto = new Producto();
            $producto->setNombre($productoData['nombre']);
            $producto->setDescripcion($productoData['descripcion']);
            $producto->setPeso($productoData['peso']);
            $producto->setStock($productoData['stock']);
            $producto->setImagen($productoData['imagen']);
            // Busca la categoría correspondiente en el array $categorias
            foreach ($categoriasObject as $categoria) {
                if ($categoria->getNombre() === $productoData['categoria']) {
                    $producto->setCategoria($categoria);
                    break;
                }
            }

            // Persiste el producto en la base de datos
            $manager->persist($producto);
        }

        // Guarda los cambios en la base de datos
        $manager->flush();
    }
}
