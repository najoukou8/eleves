    <script type="text/javascript">
        $(function () {
            $(".mapcontainer").mapael({
                map: {
                    name: "world_countries",
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
                        title: "nombre par pays",
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
                                max: 5,
                                attrs: {
                                    fill: "#97e766"
                                },
                                label: "entre 1 et 5"
                            },
                            {
                                min: 5,
                                max: 20,
                                attrs: {
                                    fill: "#7fd34d"
                                },
                                label: "entre 5 et 20"
                            },
                            {
                                min: 20,
                                max: 50,
                                attrs: {
                                    fill: "#5faa32"
                                },
                                label: "entre 20 et 50"
                            },
                            {
                                min: 50,
                                attrs: {
                                    fill: "#3f7d1a"
                                },
                                label: "plus de 50"
                            }
                        ]
                    }
                },				
                areas: 
                    <?php echo (json_encode(utf8_converter($jsonoutput), JSON_INVALID_UTF8_IGNORE)); ?>
                
            });
        });
    </script>