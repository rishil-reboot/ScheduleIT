<?php

// This class was generated on Thu, 01 Feb 2018 16:13:07 CST by version 0.1.0-dev+3a517e of Braintree SDK Generator
// OrdersCreateRequest.php
// @version 0.1.0-dev+3a517e
// @type request
// @data H4sIAAAAAAAC/+x92XIjN5bo+/0KhDwRbTm4SKrFXTUxDypJruK4qsSrpR0Tug4SzDwk0QKBNIAUi57oiPmN+b35khvYkolcVKKKotVjPEkEDpBYD85+/nPvM17A3ts9LlIQspcIwAr2OnunIBNBMkU423u7d2KKJcIMGcAeuuJIgkJqDkgJzCRONChKOFPwRSHMUgQMTygYEAniDgRSHCV8kVFQgASRtwbMlBDMEkCYYbqSRCI+rfbcQQmmFI37d4d93bRfquu6r8qx/sIMGAisAGHdPrklbIYGpz10ie/AfJCwhOapHhiRaHCKCDMfGw/xKsO0e0IJMNX9BAqnWOHuIB0jAb/lIBWaA05B6BYrngs7JMXtqJI5JLc8V327lOPeXmfv/+YgVkMs8AIUCLn39ubXzt4H00m19CcuFtWyIVbzatmFHcrVKoO9t/+5Z//unetv7nX2/oYF0ate3tW9zt7PsKqUhPt77Pd1r7N3LARe2W4P9Odwes7oau/tFFMJ9vtEQFoUDAXPQCgCeoDFgHCWUZJg3f/IbU99eM1A68E214dDv5oDKsEVJxC+ZCAI6GNF2JSLhane3gSlEoTN6nOaCMzSEdM/ylMJiiuLjyieAEVqjhXidyAESUGaMznJJWEgJdIN/UEd4tUQU4SThOdMIR6UZngGsoc+4S9kkS8QBTZTc0QkOjz6EUnCZhS6k5W+HTSbY5YvQJAEJXMscKIP2bcuEMsp/Ufnq6tEMUsJm430cIN1qlTU91qtMtD4wQGaCes7mBKZUbyqLIckCtCUC5RLEMhfUYO+cmlxE+OsW1nSct8di+c4Gr8jlBI2Gwetqy35jLCW9h913XhXC8wTTCtL64uqx+/m3cmw+/JHPexZbpYTz379fq5UJt/2+4pzKnsE1LTHxaw/VwvanyTZyx+/k2DR79F+By3nJDHnbIFTQHnmUfjN4PIcvX7xpnu07j7hKaz7Xy6XPcqT3ozf9aXCLMUilX0iuWnVz+ZZXzcYUSJVL5tn+x3TMTfjx9R8oXv46s3RS2SntR6+6z1nRPdghk8kN7CmT92l7OkZ7XfM0+BH3H1x+Pq1vSLdI2S2VqzcuPspT2SfMAUzYXBKPyUCEtUXIFXfwXY1rOzvb3m39U6agf4N01wfPtKA9DMu1QQntyP9fAUnoFpTewSwHqreOo1vupil3TvzoQwTIS2C0vgVE4bgiwKh11/31UEyT+YIS3vPpgCp/k4HyYQLsGsrOarh39fbx781zNuIczUmuYWVQQ0GCdTn20P/wXO0yKWesxBANU2hYS2InpLByhoh7Qptmk8Hs/Ml9enZYd43wW2M+dcHjFrOSZYZpC5gCkK/ycEcmuvDGV1mkJDpCl06WDQsYOXb/5cfHLxIcmr+gv1FSfmXvo729+fz0eWHwXA4+PzeVvXXdQhdQIoTJZEfEsJpKvQDPCVAU4mmgi8antsLSPhiASyF1K27sk+EXv6UzIjCFM04T2XPfTQcXttg359djX66OP80+mnw8axhuO8dCV4brgQKiYIUTVaOkFiB0G9jMO6NxnJ5djUaXpz/bXB6djo6Pj29OLu8bBjStXsY/Ugywe9Iuh7JAkQyx0z10DszJiIR4wpZVoFrSoTNwh4aCZzBtOgJpRwk+4tCGZaGRfEN7aTnWJYeDPsNzmXtG19fmb4/YX8EVpd5llFYAFNYrOqovbH6W/B70KFB8oYL0nPSW+lWy6CXEv+XCZ6A1HRmxPR/QkyvX/+RPQrB2MPycAanMNU8DlrOQc2tkCATIIFZ1JbkUvEFCLQkao4wsldRKsHZzN7GE84UYbm/pOUqxEVDgyFeoc982QTvOQQ0pXxpCH0/FoNMpB2FHtfju7UcQRW96iWyK/Rv+i0hqoZbe+gUpjinSuPM5iHctxTh1CyE0ntXRnFqDjgNCkRY7b7j+tK/jl6zicz+VffqPuuhqm0M1l3Ogd0LVzodjXD9cEj9+pAnPF3dM4cA+IGr57+VNvWksUfKzTN2y/jS7M2UMPOYrDQGRXhhuEM9d7TiOSKMKOKxTNPGtHxJ3/bUHQJ7Qi/Ach8yvCyKh2+mHYblRy2rJud8+ZhjNMmV4qyHftFzCb6ZUJLcys2661S6wKxMAYTL17w0lePw0L1uv6xf3eon3uPLFuQw+hp2eJKjcA9Se8RJaO+tE2w4kZ6SgBSRxQJSvZJ09aAj0K8hgH4Jz+3qKbSS9JEiFSIlLK8/5qkRXbMUaQh7mvTKCJA8FwmgJZbI9pF2EGHoZsA0Iw6q0tKKPO8X44hp8uLFizeFIOdV7/X+jugbkgarYn7WF2Nw6uVIWxFPP3RsTAELJdFFUX2MtmrLQ/tI2C0qfQudT/4OSYMInRJ2K0MxnytpJ/6dNqNrKd0U3Xw4vjo7P75EpqmXcOGM9PkdiDsCy/53c6yAY9k1IPuGMipUOWsGE2ea3cO0U8hHx75olAs6Nl9Y01Dj92dXY7QANeepObnuFfWNDbThStYoanxxdjq4ODspGj49ozEXMA2W2BXUz8J6SbCYgULXFx/NUi3wLbhrbJc8wZR2NPiEMHB8sVkFtzZEmsnbG359MUAKFpnhSx54r1+/+vFgv4cGha4L0Phfxh00/n5sxXHj/XFJ7G+4h0xAt8TAIT2jsZ7r2FOcmpHyh0XPlTNLpmNlzw7CxRLYOXqqXeYTqU8dU6Z4RxfZrmmwdUVRffM+XF0N/TYUrK5q2bwdzUAADYZvf9fHfmOuihmgEXKsMvjqEXn15q9/LVD/y0KGb3S1EmEjShmcmpOBS1cxZ3gxIbOc55KuUGqGMnH6KgkLzBRJCg2ubtZDlwDoxqC0CzdCGcr/CWbYjA1LSWZM0wCyr9t2/ZSqP3tfjNh+65ztwql9Gw8TroldSoXhpnj18fYUjv8csv9O1AD8ieVCz1KSGWWX8YwGp3SINa06WFuFNOBRDTIibMpDJFourk/GVD+NucmxVVQ02JtYq4QRLgBKRie1uvqYHUyhCSEMYc+H99AJZmgCBuEb5ZbeqKqy6eltahKiViETbQsaCHCiVuYU7eioO3X/KOFphc0PK2omF2rJuwX5jQaX5+jF4evX3cPHGBlYdEdSYIpMiSPFvNECF0jATJ9FKwuZUJ7c/pZzBW2isc9cwdsmgc9VqVv9aXMa3gvACr0TxOBaImuyq/fv6lpCg5Z4Xc51/XMDrCEsUm/9pHjWpXAHFKV8oT+pd1s6DGKwvhlgr1BEjk+OxvVhn8wJw2jJBU2XxJVp1gULo4nMmX49BKcUUpQJkgD6/uR6uO/4gw6aYHaLEixSS9okgkvZnRgpRflRKTSJ1WXf5HgqkT/SCIgwOKwKB0xJ/eZMiZCGiwNPu/vrjX7iAsEXrPm6DmL5YqLJPKkEgGon7J5wSke1KR3VpnTuzIMsFysh4Sx9wOxkTpSmVjMslJFE+uk+bpqPRyxMPyGU/G6NH6XCKg9xewtAg3GkQ+xBA2Qb9NAFqFwwSBFn1BIa5hFzlg7vBP6d7IrXzeachUjUlzS8tLqm2BzC0M1Z7/DoRU06YphLlfcI06gz6V91L85Ouga2e3RwcHhw1B30ge03WUy+Oti9XaTm0jCtPydhecN6mHqD3kq2ePqc/04yi/X0Mf8tJ3eYmpf9apWRBFO6WpPGFgdqRKkfESe5KfWsu8As6MVw9sM1yHrlgfWW5JZkkBLL2utf/eF6HruSNOuTXrE3Uk027kaM8pDX1zQv3l4rHrm+NDfKLJFe9fUaGQBuNNvF2uprV1rz8nuBSICe9C4ShniBtySsu3mLbo7FTL/6DG8y6O+wb7XfQTf2jm/UfmKa6MYnmOF0s48npoluPGAp2awt0S1MU4XparOmuoVu+u84w2yjpn/XLXTTT/CFJHyjtgvTRDe+mmNCMUs3aq5co/2OPlk314woSNGlBpEbdZRL3IjkXh4EVuE7R3gNL9sD3jL3eu1miJp1DgboCtpt05tpi/GH809no/OL0S/nFz+PO2j8fvDT1XjbpMVDdJMTItR8lFbxYlDcxCkKNbdaRkdDGVKhSQv5aOVjZcUO37w56B687B4ejZ81Q1cw/3+RddbuoFuwds/Fjrxt9rDAJFQ4+JL2+RqI9ZFv9jzZOV4x7EzdDScobp+TZYZ2KEeguGm05dL2wWqoXY51QdKUQn20YXn7eC3cLkfsxHZpkyyvWRdoRcRdq46CFAFLxCrTb6+V8Q1OnyNT5Ba4zBw1XcijP4Kx0WMa1Z7SoLiNzdPVuyJHMM0VrtmvBsXtC78G2/JwC6+HVjFw4UPRJAduqKxPouZDkILChEbxbhTvRvFuFO9G8W4U70bxbhTvPjfxroCEZARYA/tUq6ovrLGNcCijAEdYWRPMLSm4o6A6CqqjoDoKqqOgeuPIAfl0Sr5UzANd0T1suAHZ1aLjL1XJUlHUMsT/+a//lkjhLzYsVZ5lXCiPYeueWs4iXRNwO51SXVgTln99clZws/sZVmz9zDdOrTCjUTaoAUZpARCICCt1jZM2H3AwxRy3HE+rba9SIie5kMZedrSo0pVNteEU9NOWmNhuJf9r3wwtOIMVIkwqzBQ10gaK1c4csfz61yW36+L2HXG+C9v1HgvOVi6SOZaA9GvXMHpXPcoZUZWDVa1qt2/2oMiA9tAZTuZhIQKp8IQSOQfrgMOUfhrRBNQSnPuglVprBK7/g40MnOvMfMks1Ti9NkR28+WlYG6+qH3HLEjH8ia7Ez/mQgBLKiLIdWED9a3mAiAU8HVfHh3+iHyzh8n5HHCh5POIMeVgo6JIizoRptR3TTY04/6qKMZjSLuV7YiyCUHehxhxmhIXosvjRjzhuWry7H7yPZ6RqRotBc6C4ZdL6xPQtUjXoilAo2KzLEEo+HLrcXd/UKJLuANmAwNJNIEpF1aYmUJCFvpl5GTt794cnudqQ/Al99/DU31kH/i5IubNbjD+HLPUmKxPIXzJKhX13fIAcbP0kJ8fUUmYzAWuhv4qlza5VrvauKnBphbC3Nad3RVT7HSGjdrG+7WMcUd3hVML7W9KZFIjy5pq79825CHjjXx+aFbmE8UVphWZSVHYsLWu0gew8VMhChY20J4VjtsI2H4rrbLNwHSssDyzg13pU/DDD17r8MMP8ZbvSmhTFdY0i/7wl7gjOxJf1m9i+zUM7qDeipmNPuG5d/ABNA0rbyW2AqY5S2UHCXBh6qxS0PViDCbW7R2075QLMvMBrJrtxOKZ2IynflBYKBMjqyJqcEUN9k42F0ERQ7UIvDA4NRYw5oQISDhLCPXgoZrOyFLcsxRYrqxtAwgL/OCNmB+Usk74+mxxoWQP6cXwEomvPXk7eu3S0oqFcolyeYPAycvPSoA744PuOElgZI0bKsxQpapJUiYUA9FwIlxjZzThdodIn6/jD9y8gYJFwzpo0iGcvitpl4VakuTJgzM8H4Hg875FejuCG4SeIYv68EgbZjrGuPS5ODEYy8RQceBKWkafcBm5st3szW85ZqpquFwqbNkhD/HVXdoVv3ibh6yi+d3AJSqe3KJbACMFMGqn7y9/vt4P2MXe82J1zIIbfucZ4qVchJyB/V2fxPXFR03kmbmUI8ug4ztMqA+br0rRZ2pJueZEKi5WMVZajJUW41DFWGkxVlo8ow+OldbuwKDIdDWqvmJBcbuhhwFzGfukiZK73dUeWjYZ/QRwn+WXARpNAVqsv5rqW3lyoxqxrloSJZy6BDxrEyQnbitdo+09eCdr7vSbLHEmWMKaZ+Um6LS1HKfUxLtnCcHUnsQifrTNjVQxIp1gilkCnbWBXA7bcyd6OBN/UnPd+99i2bMbpONtsvJM05k/fP6hnTmTkGGBFRcdTeGkJq9LaqNDuFXcdN2K22OiiGfC5FMIdqK3ZbntEK+MgUndywTIXUVeVypsNoYFtJwb+awGs6J5K4LX12Ca0ymhVD7SQPExd2KT8A5BWAeEpeQJMbe9iN5uZvgXWUmBWWgM1yLKoCef76vSIWarSkedkuoiwcxybm4tPegvmFJQHsXIHjo1hwklAlKijANnUYmw0EeVEUg1LjKJwHR9Kf+wI3xsX7sKUW6TmFVtXMPyhu0pAhJUMpCWrF6bTD2//WXV+3Hqkq1+auUAzbdHLinrqJEfbAVpSIphgbrmDHjI7c7zKTL7lp0SglS+W94Uvx1D51BZtxE3S1z3wKzWtKCxakyJpzfJfXQUnodG3/F+jCncAdVD62Um/Xcv4YvNvPNLsZD0QnkH9R1Jt+tapHu0R4R1/So0eti+fulKTPJiitnDHW5fv+weHRweHB52B/s7cw96/HtWRh1iR/L+XxvCUEML5qwjyj+EyHjU5Y1URqQyIpURqYxIZUQqI1IZfwSV8XDPSm+9wUWL42up+j7fVw/mk3XbdHDlB9I4+RtoPi2eEZwockfUts+xuVQg2qdNCbuFdDQTPM8aJ14BqKlUBqdW1GsAJFrkVJGM2nxXkNacNgObs8A8T5MLrlGgmi4c5FworWlh7tlDx+6/ME1m0FyadPkkCZQ2mgRy6mGJF8V3zRy2/4Cb4V/miwUWq/adkAVAfRPWde1Hz8Fs77G4xLThccO5mnPhoiuFaoJaVbv+LQR1EVmCs6I3N3Tu1UTpHN8B+h0ER1ygBRdQ6Wl7Orjozxv9eaM/b7SSi/680dEs+vNGf97ozxv9eSOajf680Z83+vNGf97ozxv9eavCBgFYwUiRir4mLG/QNWFlLY41BFrOXZw2AZLnIgG0xBLZPtKmBEtFy0dnWtoRlxDqG1vUjINTr9+QmMI2LWQrw/xI2C0qfR+dGwvXxjj0t7Iah/72fumee1ILs9ibD8dXZ+fHl0bOWgTBxRnp8zsQdwSW/e/mWAHHsmtA9p/eln4uYBry4bagwfWcLzIKSj8wYgbKGGmjK44W+BbcUbXTTDClHQ0+0RSErnFUklPhE0Nb3NpTfH0xQAoWGd0gS9jrVz8e7PfQwCIqm/ThX8YdNP7exaQd749LiM1GuRfQLfkoGAH8WM917AOn38IK+Q3Sc+UMPIo1m2EiKdolsHP0EdNlPpF6pzVax5TuTIOv17TqT2WL6pv34epq6Leh8OZQLZu3s0DttGI92/xw3ujltwPUN1StMvjqEXn15q9/LdDby33/tkkQdyARlggzb7KAzfbajc4ZXkzILOe5pCunxZo4GxoJC8wUSaRHTbqZi4hv0MiFG6Gs6C0xswHxbe4oY+XR1227fkrVn70vehq702duFsnaVu0IP7e7MZS+WZMl1uv+WRwbvkm/ET0bomfDFijYPEsbKdiw/HEUrElNaDt6xmRseZVOcKZy0aABTmxFiDdLhe10oQf6Fn2v7yNqeqOmN2p6o6Y3anqjCiJqeqOmN2p6o6Y3anqjpjdqeqOmN+5I1PTGM/FkcrJNVZlOZBO1mVGbGbWZUZsZtZlP81ILwJKzug9vWF7Bc8jW2rTnNmZbkQfTHihT7QnqshOdy549ReMMWErYbIy4QGMBdyAkpONnmY64GPRuHqaoxo1q3KjG3aYat4wJLww30IQJDZdQwYK+7D5Kz3IX36CedF1E7WTUTkbtZNRORu1kFJtH7WTUTkbtZNRORu1k1E5G7WTUTsYdidrJeCaezg/VCnWrAV6D4k0cL21iWRNv7nl6iroQeGUhdtNRe8KsjVH9GtWvUf0a1a9/bmdSTGuPzrrsWb843+IHu8WBlle5OfioXilZW+H73w8D8S0qHdNBVOhEhU5U6ESFTlToREljVOhEhU5U6ESFTlToRIVOVOhEhU7ckajQiWciBhaNgUWjLijqgqIuKOqCYmDRGFg0eqRFj7QYWDQGFt0gF+tjPJiv1k7KxofZPkAb+SmjsztgKseUrpxgxmAltCSUaj6R4gSKxiP7sXEP6SXwV/Fr8qydEQBT0Me7ZohQqagvoc9/HuQzD7Tl253BpZeOHtsMwffIYHEB0SCCXVfeI4H1WYh3px8nqqIbtwUNPABRq6dIUb7dTN/H9Tzf56jI8/2AJ62Sw9sGGkiBKTIljhr0mbKNkGamCR8rbphQntz+lnMFZSGEVIKzmS35zBU42Uq/XI6uSt0WyOG9ZvnRO0EUJkyzKralrrfN3r9zfa2LiuTDVdjrnxtgJcqlfbtMyASedSncgX6/F/qTerd9RmysigTm6Fo6zuvkaFwf9smcMIyWXNB0SVyZ5p6w0LuLcpZwpgSnFFKUCZIA+v7kerjv8I+mqdityT9tCalEcCm7Ey5S/Q6X8jB7mU912bdqQNF2OilhcFiVCZiS+s2ZEiGVlak7ytld8wox6XOuSyUA1GPJyG+a0lFtSke1KZ1n1vLDMtISEs7SB8xO5kRp2jjDQpn3xk93a9TyQzPja/KCujzMowYGqAWg0QrGYOuggWOSeugCVC5YWaNrhLESTQVfoHcC/052xW6bnP5hvm5X0mCv1ZT//+jFwxP+H73oHh0cHB4cdQd9YPtNwudXB09n4t26BlwqTOvPSVjesB6m3qC3Qkxu34HfSWaxnj7mv+XkDlNgqoeuVhlJNI22FrdYHKgRpX5EnPCo1LPuArOgFyNcGK5B1isPrLcktySDlFjpgv7VH67nsb8zIi4hGQGmRvqlqJBxlar6wuqKtW2mA0dGq0FkgUR2Z1cKNSlI87hvHkJHmOYBf4fR9aWn8C3Vut5tA8DVHEqnRCOQ0ukpv3yIBIhWn0fCEC8wsIR1N2/RzbGYafqF4U0G/R32rfY76MZiq43aT0wT3fgEM5xu9vHENNGNBywlm7UluoVpqjBdbdZUt9BN/x1nmG3U9O+6hW76Cb6QhG/UdmGa6MZXc0woZulGzZVrtN/RJ+vmmhHN5V1qELlRR7nEjej65QGShM0odCcrBbtH3ZsJKf2tcO/wjjT0ujqQQ9qCBl3wKjP3tJlKGn84/3Q2Or8Y/XJ+8fO4g8bvBz9djbdNJP26iWVRg7ahXncPT+vkCpV5Xl8OL4dYJECfZ/i1mlxm6wt/AfYiouuLj7LpcbXVo1zQaoCosKZJzFTquvSQPMC20BL1haxIglKEzSTCJmSUpmgtV4ZZAtT2/23cyQNkFOZberYVP8lScX0Nri8+ouUcnHGCIb01LvNLA6kT7RprCSRNkD3doSzbsO+MkNILW5thULyNGRr58h1sf4pPrWoy3H8PHRfC+CSXii9AhFMyYB2rnLLtiUTj4+Hw4vxvZ6fjcgf+2BOJFthJKYourCy6+OV1v7LW9cn5p+HHsyvd925OShTQ//oPDSUzziTYfopFO9e7VV+zYKGarDbs6dqarBVnGSWJlR4knCn40uRE1QhU8qhqrG+gdtZwyMEh+JKBIMASQITZzSK7UEZOBGZpnRcMiqviWoonQK18kd+BECR1d3mSS8KMdEXziU5E6d4snBj+BnEWvmQzzTY12Lod/RgQsJhmc8zyBQiS7J6a1aS6pp30cENxW1jRTjo6QDNhpDhKicwoXlWWQxJrVoNyqXHYHJJbnitjt5M7AS7jrFtZ0nLfHf386w+M3xFKCZuNg9bVlnxGWEv7j7puVziS8sT6ZJaW1hfVtAXvTobdlz/qYc9ys5x4dj9imyTZyx8LtHa0XxIKmYckz/yjdTO4PEevX7zpHq27DyU5y+WyR3nSm/E7zYmxFItU9onkplU/m2dGXD+iRKpeNs/27QPEnQTWapwPX705eonstNbDd73njBj9sR4+kdzAmj51l7JnjE06xXNn+ntx+Pq1vSLdo0C6v6HuZMu7rXfSDPRvmOb68BHRLOSb4OR2lGKFa2K+ck276Z7GN13M0q6xFkAZJkJ6BQgzqhj4op9FTPWziDtI5snc6VIEmgKk+jsdJBMu7jEGeQKDvhrmbZW93cKaD2iYbw/9B8/RIpd6zsJawBhYC2J0THo7NEJ6jtYcdpj3TXDnXHRWKLabOemgPpzRZQYJma5QoYkeFrD3W2pXdYCfz0eXHwbD4eDz+7oyEF1AihMl68poa/lk1Rb15/YCEr5YAEshdeuu7BOhl98Y0WCKZpyn8n4j75py8+xq9NPF+afRT4OPZw3DfQ/W/r02XAnUcj/Opn6Sa8aIs3DcG43l8uxqpHmIwenZ6ej49PTi7PKyYUheL+pHojkTkq5H4k0Xeuhd7pg1xhUyalHFNSXCZmEPjQTOYLo2gkg5SPYXhTIsjWGjb2gnPcey9GDYb3Aua9/4+soUpvR/BFaXeZZR0OwaFqs6am+s/hb8HnRokPxakzNZ+dWqSOVRycQ4Yvo/H6bXr//IHoWQMw/KwxmcGuNBqflxo/xRHDlfn1DI4RSGdYOSE84UYTk02ZRw0dBgiFfoM182wXsOAU0pXxpC34/FIBPpbfjhG7q1HEEVveolsiv0b/otIaqGW3voFKY4p8rrXjdbinBqFkLpvSujODUHnAYFIqx233F96V9Hr9lEZv+qe3Wf9VDVNgbrLufA7oUrnY5GuH44pH59yBOeru6ZQ9pmmXTP6vlvpU09aeyRcvOM3TK+NHsz9Z5npSggVuS04jkijCjisUzTxrR8yfqM2UNgT6gXoMvwsjgXuIp42/KjzhVgzpePOUaTXCnOeugXLz4rvplQktzKzbrrVLrArEwBVIKoNC5N5Tg8dK/bL+tXt/qJ9/iyBTmMvoYdnuQo3IPUHnES2nvrVAXSjpKAFJHFAlK9knT1oCPQryGAfgnP7eopjH6QW/WD3Ip4+sGRXBRUgkgURU0xXNT2lWTP3S9TU0Zrh8iCwbSKKEw7hXx07ItGuaBj62pW0FDj92dXY++Wp0+ue0V947Vj2hpFjS/OTgcXZydFw+gjGn1Eo49o9BHdznO+AIWd9KR+mHBN7FIqDDflk6vYnsLxn0P234kagD+xXOhZSjKj7DKe0eCUDo2V2GBtFdKARzXIiLApD5FoubgxzC+IpzE3aXW8nFirhEa/y3pdQxwAC7O2o2cIF2Zx6AQzNAGD8I1ya2qM6EJlU3TQjA6a0UEzOmhGB83ooBkdNKOD5jNz0IxujdGtMbo1RrfG6NZY4hmFmo/SKl4Mips4RaHmVsvoaChDKjRpIR+tfKys2OGbNwfdg5fdw6Pxs2boCub/L7LO2h10C9buudiRt80eFpiECgdf0j5fA7E+8s2eJzvHK4adqbvhBMXtc7LM0A7lCBQ3jbZc2j5Y47K2w7EuSJpSqI82LG8fr4Xb5Yid2C5tkuU16wKtiLhr1VGQImCJWGX67bUyvsHpc2SK3AKXmaOmC3n0RzA2ekyj2lMaFLexebp6V+QIprnCNfvVoLh94ddgMf5eFO9G8W4U70bxbhTvRvFuFO9G8W6MvxcF1VFQHQXVUVAdBdUPjxyQT6fkS8U80BXdw4YbkN7O0hJWJUtFUcsQ/+e//lsihb+gwWkPPcMUm3b8dWFNWP71yVnBze5n+GtD8vfWrO9uEKOm7O/1uvbU/j4FfBBD7ellJymRk1xIYy87WlTpyqbacAr6aUs0ki77X/tmaMEZrBBhUmGmqJE2UKx25ojl178uuV0Xt+9IKTfG9rzHgrPlM27o165h9K56lDOiKgerWtVu3xyk9ZA9dIaTeViIQCo8oUTOwTrgMKWfRjQBtQTnPmil1hqBm1SZGxk43xeu8njhMipXI7stanmYi6L2HfMJiAxvsjvx4zpL1P/C1FFfFcV4DGm3sh1RNiHI+xAjTlPiQnR53IgnPFdNnt1PvsczMlWjpcBZMPxyaX0Cuhbp2pjKfWdJnueYpcZkvZrSrlJR3y0PEDfreeZtJ0zmAldDf5VLm1yrXW3c1GBTHxDCekdMsdMZNmob79cyxh3dFU4ttL8pkUmNLGuqvX/bkIeMN/L5oVmZT+pJ+UuFDVvrKn0AGz8VomBhA+1Z4biJGVFspVW2GRiXhTGzg13pU/DDD17r8MMP8ZbvSmhTFdY0i/7wl7gjOxJf1m9i+zUM7qDeipmNPuG5d/ABNA0rbyW2AqY5S2UHCXBh6qxS0PViDCbW7R2075QLMvMBrJrtxOKZ2H5yYRsjqyJqcEUN9k6UAFPdIoZqEXhhcGosYMwJEZBwlhDqwUM1nZGluGcpsFxZ2wYQFvjBGzE/KGWd8PXZ4kLJZ5lBNy2tWCiXKJc3CJy8/KwEuDM+6I6TBEbWuKHCDFWqmiRlQjEQDSfCNXZGE253iPRZQ/7AzRsoWDSsgyYdwum7knZZqCVJnjw4w/MRCD7vW6S3I7hB6BmyqA+PtGGmY4xLn4sTg7FMDBUHrqRl9AmXkSvbzd78lmOmqobLpcKWHfIQX92lXfGLt3nIKprfTamoeHKLbgGMFMConb6//Pl6P2AXe8+L1TELbvidZ4iXqnnO7ktwpridSzmyDDq+w4T6sPml5GfOjrpE0M2JVFysYqy0GCstxqGKsdJirLR4Rh8cK63dgUGR6aqWrTMobjf0MGAuY580UXK3u9pDyyajnwDus/wyQKMpQIv1V1N9K09uVCPWVUuihFOXgGdtguTEbaVrtL0H72TNnX6TJc4ES1jzrNwEnbaW45SaePcsIZjak1jEj7a5kSpGpBNMMUugszaQy2F77kQPZ+JPaq57/1sse3aDdLxNVp5pOvOHzz+0M2cSMiyw4qKjKZzU5HVJbXQIt4qbrltxe0wU8UyYfArBTvS2LLcd4pUxMKl7mQC5q8jrSoXNxrCAlnMjn9VgVjRvRfD6GkxzOiWUykcaKD7mTmwS3iEI64CwlDwh5rYX0dvNDP8iKykwC43hWkQZ9OTzfVU6xGxV6ahTUl0kmFnOza2lB/0FUwrKoxjZQ6c25XciICXKOHAWlSZ7dwqMQKpxkUkEputNwHJirEwc4WP72lWIcpvErGrjGpY3bE8RkKCSgbRk9dpk6vntL6vej1OXbPVTKwdovj1ySVlHjfxgK0hDUgwL1DVnwENud55Pkdm37JQQpPLd8qb47Rg6h8q6jbhZ4roHZrWmBY1VY0o8vUnuo6PwPDT6jvdjTOEOqB5aL8OrDNNewhebeeeXYiHphfIO6juSbte1SPdojwjr+lVo9LB9/dKVmOTFFLOHO9y+ftk9Ojg8ODzsDvZ35h70+PesjDrEjuT9vzaEoYYWzFlHlH8IkfGoyxupjEhlRCojUhmRyohURqQy/ggq4+Geld56g4sWx9dS9X2+rx7MJ+u26eDKD6Rx8jfQfFo8IzhR5I6obZ9jc6lAtE+bEnYL6WgmeJ41TrwCUFOpDE6tqNcASLTIqSIZtfmuIK05bQY2Z4F5niYXXKNANV04yLlQWtPC3LOHjt1/YZrMoLk06fJJEihtNAnk1MMSL4rvmjls/wE3w7/MFwssVu07IQuA+ias69qPnoPZ3mNxiWnD44ZzNefCRVcK1QS1qnb9WwjqIrIEZ0Vvbujcq4nSOb4D9DsIjrhACy6g0tP2dHDRnzf680Z/3mglF/15o6NZ9OeN/rzRnzf680Y0G/15oz9v9OeN/rzRnzf681aFDQKwgpEiFX1NWN6ga8LKWhxrCLScuzhtAiTPRQJoiSWyfaRNCZaKlo/OtLQjLiHUN7aoGQenXr8hMYVtWshWhvmRsFtU+j46NxaujXHob2U1Dv3t/dI996QWZrE3H46vzs6PL42ctQiCizPS53cg7ggs+9/NsQKOZdeA7D+9Lf1cwDTkw21Bg+s5X2QUlH5gxAyUMdJGVxwt8C24o2qnmWBKOxp8oikIXeOoJKfCJ4a2uLWn+PpigBQsMrpBlrDXr3482O+hgUVUNunDv4w7aPy9i0k73h+XEJuNci+gW/JRMAL4sZ7r2AdOv4UV8huk58oZeBRrNsNEUrRLYOfoI6bLfCL1Tmu0jindmQZfr2nVn8oW1Tfvw9XV0G9D4c2hWjZvZ4HaacV6tvnhvNHLbweob6haZfDVI/LqzV//WqC3l/v+bZMg7kAiLBFm3mQBm+21G50zvJiQWc5zSVdOizVxNjQSFpgpkkiPmnQzFxHfoJELN0JZ0VtiZgPi29xRxsqjr9t2/ZSqP3tf9DR2p8/cLJK1rdoRfm53Yyh9syZLrNf9szg2fJN+I3o2RM+GLVCweZY2UrBh+eMoWJOa0Hb0jMnY8iqd4EzlokEDnNiKEG+WCtvpQg/0Lfpe30fU9EZNb9T0Rk1v1PRGFUTU9EZNb9T0Rk1v1PRGTW/U9EZNb9yRqOmNZ+LJ5GSbqjKdyCZqM6M2M2ozozYzajOf5qUWgCVndR/esLyC55CttWnPbcy2Ig+mPVCm2hPUZSc6lz17isYZsJSw2RhxgcYC7kBISMfPMh1xMejdPExRjRvVuFGNu001bhkTXhhuoAkTGi6hggV92X2UnuUuvkE96bqI2smonYzayaidjNrJKDaP2smonYzayaidjNrJqJ2M2smonYw7ErWT8Uw8nR+qFepWA7wGxZs4XtrEsibe3PP0FHUh8MpC7Kaj9oRZG6P6Napfo/o1ql//3M6kmNYenXXZs35xvsUPdosDLa9yc/BRvVKytsL3vx8G4ltUOqaDqNCJCp2o0IkKnajQiZLGqNCJCp2o0IkKnajQiQqdqNCJCp24I1GhE89EDCwaA4tGXVDUBUVdUNQFxcCiMbBo9EiLHmkxsGgMLLpBLtbHeDBfrZ2UjQ+zfYA28lNGZ3fAVI4pXTnBjMFKaEko1XwixQkUjUf2Y+Me0kvgr+LX5Fk7IwCmoI93zRChUlFfQp//PMhnHmjLtzuDSy8dPbYZgu+RweICokEEu668RwLrsxDvTj9OVEU3bgsaeACiVk+Rony7mb6P63m+z1GR5/sBT1olh7cNNJACU2RKHDXoM2UbIc1MEz5W3DChPLn9LecKykIIqQRnM1vymStwspV+uRxdlbotkMN7zfKjd4IoTJhmVWxLXW+bvX/n+loXFcmHq7DXPzfASpRL+3aZkAk861K4A/1+L/Qn9W77jNhYFQnM0bV0nNfJ0bg+7JM5YRgtuaDpkrgyzT1hoXcX5SzhTAlOKaQoEyQB9P3J9XDf4R9NU7Fbk3/aElKJ4FJ2J1yk+h0u5WH2Mp/qsm/VgKLtdFLC4LAqEzAl9ZszJUIqK1N3lLO75hVi0udcl0oAqMeSkd80paPalI5qUzrPrOWHZaQlJJylD5idzInStHGGhTLvjZ/u1qjlh2bG1+QFdXmYRw0MUAtAoxWMwdZBA8ck9dAFqFywskbXCGMlmgq+QO8E/p3sit02Of3DfN2upMFeqyn//9GLhyf8P3rRPTo4ODw46g76wPabhM+vDp7OxLt1DbhUmNafk7C8YT1MvUFvhZjcvgO/k8xiPX3Mf8vJHabAVA9drTKSaBptLW6xOFAjSv2IOOFRqWfdBWZBL0a4MFyDrFceWG9JbkkGKbHSBf2rP1zPY39nRFxCMgJMjfRLUSHjKlX1hdUVa9tMB46MVoPIAonszq4UalKQ5nHfPISOMM0D/g6j60tP4Vuqdb3bBoCrOZROiUYgpdNTfvkQCRCtPo+EIV5gYAnrbt6im2Mx0/QLw5sM+jvsW+130I3FVhu1n5gmuvEJZjjd7OOJaaIbD1hKNmtLdAvTVGG62qypbqGb/jvOMNuo6d91C930E3whCd+o7cI00Y2v5phQzNKNmivXaL+jT9bNNSOay7vUIHKjjnKJG9H1ywMkCZtR6E5WCnaPujcTUvpb4d7hHWnodXUgh7QFDbrgVWbuaTOVNP5w/ulsdH4x+uX84udxB43fD366Gm+bSPp1E8uiBm1Dve4entbJFSrzvL4cXg6xSIA+z/BrNbnM1hf+AuxFRNcXH2XT42qrR7mg1QBRYU2TmKnUdekheYBtoSXqC1mRBKUIm0mETcgoTdFargyzBKjt/9u4kwfIKMy39GwrfpKl4voaXF98RMs5OOMEQ3prXOaXBlIn2jXWEkiaIHu6Q1m2Yd8ZIaUXtjbDoHgbMzTy5TvY/hSfWtVkuP8eOi6E8UkuFV+ACKdkwDpWOWXbE4nGx8Phxfnfzk7H5Q78sScSLbCTUhRdWFl08cvrfmWt65PzT8OPZ1e6792clCig//Ufnb0TzhQw5dYKZxkliaVt/i452+vsfVAq+2Tfprd7w/PLq73O3hCr+d7bvf7dYT+ZQ3LLc9U3+6sP4NmXzFyZS7O3Rpv29ujg4B//5/8DAAD//w==
// DO NOT EDIT

namespace PayPal\v1\Orders;

use BraintreeHttp\HttpRequest;class OrdersCreateRequest extends HttpRequest 
{
    function __construct()
    {
        parent::__construct("/v1/checkout/orders?", "POST");
        $this->headers["Content-Type"] = "application/json";
    }

    
}
