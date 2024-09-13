    <script type="text/javascript">
        $(function () {
            $(".mapcontainer").mapael({
                map: {
                    name: "france_departments",
					"zoom": {
						"enabled": true,
						"maxLevel": 10
					},
                    defaultArea: {
                        attrs: {
                            stroke: "#fff",
                            "stroke-width": 1
                        },
                        attrsHover: {
                            "stroke-width": 2
                        }
                    }
                },
                legend: {
                    area: {
                        title: "Nombre par département",
                        slices: [
						{
                                max: 0,
                                attrs: {
                                    fill: "#b4afae"
                                },
                                label: "aucun "
                            },
                            {
                                  min: 1,
                                max: 3,
                                attrs: {
                                    fill: "#97e766"
                                },
                                label: "entre 1 et 3"
                            },
                            {
                                min: 3,
                                max: 10,
                                attrs: {
                                    fill: "#7fd34d"
                                },
                                label: "entre 3 et 10"
                            },
                            {
                                min: 10,
                                max: 30,
                                attrs: {
                                    fill: "#5faa32"
                                },
                                label: "entre 10 et 30"
                            },
                            {
                                min: 30,
                                attrs: {
                                    fill: "#3f7d1a"
                                },
                                label: "plus de 30"
                            }
                        ]
                    }
                },				
                areas: 
                    <?php echo (json_encode(utf8_converter($jsonoutput), JSON_INVALID_UTF8_IGNORE)); ?>
                
            });
        });
    </script>