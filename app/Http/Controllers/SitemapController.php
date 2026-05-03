<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $propiedades = Propiedad::aprobadas()->select('id', 'updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Estaticas
        foreach (['/', '/propiedades', '/comparar', '/login', '/register'] as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . url($url) . "</loc>\n";
            $xml .= "    <changefreq>daily</changefreq>\n";
            $xml .= "    <priority>" . ($url === '/' ? '1.0' : '0.8') . "</priority>\n";
            $xml .= "  </url>\n";
        }

        // Propiedades
        foreach ($propiedades as $p) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . route('propiedades.show', $p) . "</loc>\n";
            $xml .= "    <lastmod>" . $p->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /agente\nDisallow: /cliente\n\nSitemap: " . url('sitemap.xml');
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
